<?php 

namespace apo\rxts\middleware;

use awsm\wp\libraries\middleware\Middleware as HttpMiddleware;

class Middleware extends HttpMiddleware
{

    /**
     * Add all provided middlewares, included namespace path
     */
    protected $middlewares = [
        'apo\rxts\middleware\Cors',
        'apo\rxts\middleware\Authenticate',
    ];

}