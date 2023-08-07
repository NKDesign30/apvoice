<?php 

namespace apo\trng\rest;

use awsm\wp\libraries\interfaces\RegisterableInterface;

class Routes implements RegisterableInterface 
{

    public function __construct()
    {

    }

    public function register()
    {
        $routes = [
            'apo\trng\rest\routes\Results',
        ];

        foreach ($routes as $route) {
            $routeObject = new $route();
            $routeObject->register();
        }
    }
}
