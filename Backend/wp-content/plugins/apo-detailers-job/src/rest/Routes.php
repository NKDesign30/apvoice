<?php

namespace apo\detailersjob\rest;

use awsm\wp\libraries\interfaces\RegisterableInterface;

class Routes implements RegisterableInterface
{
    public function __construct()
    {

    }

    public function register()
    {
        $routes = [
            'apo\detailersjob\rest\routes\InformationalTrainings'
        ];

        foreach ($routes as $route) {
            $routeObject = new $route();
            $routeObject->register();
        }
    }
}
