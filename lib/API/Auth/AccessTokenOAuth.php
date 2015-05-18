<?php

namespace API\Auth;

use API\Core\Model\Users;
use API\Storage;
use Slim\Slim;

class AccessTokenOAuth {

    private $app;
    private $server;

    function __construct() {
        // Slim
        $this->app = Slim::getInstance();

        // OAuth
        $this->server = new \League\OAuth2\Server\AuthorizationServer();
        $this->server->setSessionStorage(new Storage\SessionStorage());
        $this->server->setAccessTokenStorage(new Storage\AccessTokenStorage());
        $this->server->setRefreshTokenStorage(new Storage\RefreshTokenStorage());
        $this->server->setClientStorage(new Storage\ClientStorage());
        $this->server->setScopeStorage(new Storage\ScopeStorage());
        $this->server->setAuthCodeStorage(new Storage\AuthCodeStorage());

        $authCodeGrant = new \League\OAuth2\Server\Grant\AuthCodeGrant();
        $this->server->addGrantType($authCodeGrant);

        $refrehTokenGrant = new \League\OAuth2\Server\Grant\RefreshTokenGrant();
        $this->server->addGrantType($refrehTokenGrant);

        $passwordGrant = new \League\OAuth2\Server\Grant\PasswordGrant();
        $passwordGrant->setVerifyCredentialsCallback(function ($username, $password) {
            $results = Users::where('username', '=', $username)->get();

            if(count($results) !== 1) {
                return false;
            }

            if(password_verify($password, $results[0]['password'])) {  //using password hashing
                return $username;
            }
        });
        $this->server->addGrantType($passwordGrant);
    }

    function AccessToken() {
        try {
            $response = $this->server->issueAccessToken();
            $res = $this->app->response();
            $res->status(200);  //test
            $res->write(json_encode($response));
            $res->headers->set('Content-Type', 'application/json');
            return $res->finalize();

        } catch (\League\OAuth2\Server\Exception\OAuthException $e) {
            $res = $this->app->response();
            $res->status(401); //test
            $res->write(
                json_encode([
                    'error'     =>  $e->errorType,
                    'message'   =>  $e->getMessage(),
                ]),
                $e->httpStatusCode,
                $e->getHttpHeaders()
            );
            $res->headers->set('Content-Type', 'application/json');
        }

    }

}