<?php 

namespace awsm\wp\libraries\middleware;

use awsm\wp\libraries\interfaces\InitializeRestApiInterface;

class Middleware implements InitializeRestApiInterface
{

    /**
     * Add all provided middlewares, included namespace path
     */
    protected $middlewares = [];

    /**
     * Initialize middlewares at rest_api_init wordpdress hook
     * @link https://developer.wordpress.org/reference/hooks/rest_api_init/
     * 
     * @param WP_REST_Server $wp_rest_server
     */
    public function initialize( $wp_rest_server )
    {
        foreach ($this->middlewares as $middleware) {
            (new $middleware())->handle();
        }
    }

}