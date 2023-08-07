<?php 

namespace dwnld\rest;

use awsm\wp\libraries\interfaces\RegisterableInterface;

class Routes implements RegisterableInterface 
{

    public function __construct()
    {

    }

    public function register()
    {
        $routes = [
            'dwnld\rest\routes\Downloads'
        ];

        foreach ($routes as $route) {
            $routeObject = new $route();
            $routeObject->register();
        }
    }
}
