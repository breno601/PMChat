<?php

require_once dirname(__FILE__) . '/vendor/autoload.php';

use API\Application;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use League\OAuth2\Server\ResourceServer;
use API\Storage;

// Set up the OAuth 2.0 resource server
$sessionStorage = new Storage\SessionStorage();
$accessTokenStorage = new Storage\AccessTokenStorage();
$clientStorage = new Storage\ClientStorage();
$scopeStorage = new Storage\ScopeStorage();

$server = new ResourceServer(
    $sessionStorage,
    $accessTokenStorage,
    $clientStorage,
    $scopeStorage
);

// Initializes it in development mode
$_ENV['SLIM_MODE'] = 'development';

// Load confs
$config = array();

$configFile = dirname(__FILE__) . '/share/config/' . $_ENV['SLIM_MODE'] . '.php';

if (is_readable($configFile)) {
    require_once $configFile;
} else {
    require_once dirname(__FILE__) . '/share/config/default.php';
}

// Creates the application
$app = new Application($config['app']);

// This is strictly if configuration mode is production
$app->configureMode('production', function () use ($app) {
    $app->config(array(
        'log.enable' => true,
        'log.level' => \Slim\Log::WARN,
        'debug' => false
    ));
});

// This is strictly to development configuration mode
$app->configureMode('development', function () use ($app) {
    $app->config(array(
        'log.enable' => true,
        'log.level' => \Slim\Log::DEBUG,
        'debug' => false
    ));
});


// Get log writer
$log = $app->getLog();

try {
    // This initializes the connection with the DB
    $capsule = new Capsule();
    $capsule->addConnection($config['db']);
    $capsule->setEventDispatcher(new Dispatcher(new Container));
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
} catch (\PDOException $e) {
    $log->error($e->getMessage());
}


// Parses JSON body
$app->add(new \Slim\Middleware\ContentTypes());

// JSON Middleware
$app->add(new API\Middleware\JSON('/api/v1'));

// Auth Middleware (outer)
$app->add(new API\Middleware\AuthenticationTokenOAuth($server));
