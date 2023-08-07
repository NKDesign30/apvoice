<?php 

namespace apo\apopoints\rest;

use awsm\wp\libraries\interfaces\RegisterableInterface;

class Routes implements RegisterableInterface 
{

    public function __construct()
    {

    }

    public function register()
    {
        $routes = [
            'apo\apopoints\rest\routes\ApoPoints'
        ];

        foreach ($routes as $route) {
            $routeObject = new $route();
            $routeObject->register();
        }
    }
}
