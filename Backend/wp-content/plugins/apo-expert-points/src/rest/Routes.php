<?php 

namespace apo\expertpoints\rest;

use awsm\wp\libraries\interfaces\RegisterableInterface;

class Routes implements RegisterableInterface 
{

    public function __construct()
    {

    }

    public function register()
    {
        $routes = [
            'apo\expertpoints\rest\routes\ExpertPoints'
        ];

        foreach ($routes as $route) {
            $routeObject = new $route();
            $routeObject->register();
        }
    }
}
