<?php

namespace API\Middleware;


class AuthenticationTokenOAuth extends \Slim\Middleware {

    private $server;

    function __construct($server) {
        if (!isset($this->app)) {
            $this->app = \Slim\Slim::getInstance();
        }

        $this->server = $server;
    }

    /**
     * Call
     *
     * Perform actions specific to this middleware and optionally
     * call the next downstream middleware.
     */
    public function call()
    {
        try {
            $isRequestNewToken = (bool) preg_match('/\/oauth\/token$/', $this->app->request->getPath());
            if (!$isRequestNewToken) {
                $this->server->isValidRequest(false);
            }
            $this->next->call();
        } catch(\League\OAuth2\Server\Exception\OAuthException $e) {
            $res = $this->app->response();
            $res->status(401);
            $res->write(
                json_encode([
                    'error'     =>  $e->errorType,
                    'message'   =>  $e->getMessage(),
                ]),
                $e->httpStatusCode,
                $e->getHttpHeaders()
            );
            $res->headers->set('Content-Type', 'application/json');
            return true;
        } catch(\Exception $e) {
            echo 'Slim Exception';
            echo $e; //test
        }
    }

}