<?php

namespace API\Core\Controller;

class Core {
    public $app;

    public function __construct() {
        if (!isset($this->app)) {
            $this->app = \Slim\Slim::getInstance();
        }
    }
}