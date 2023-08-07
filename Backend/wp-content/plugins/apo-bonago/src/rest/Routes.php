<?php 

namespace apo\bonago\rest;

use awsm\wp\libraries\interfaces\RegisterableInterface;

class Routes implements RegisterableInterface 
{

    public function __construct()
    {

    }

    public function register()
    {
        $routes = [
            'apo\bonago\rest\routes\Vouchers'
        ];

        foreach ($routes as $route) {
            $routeObject = new $route();
            $routeObject->register();
        }
    }
}
