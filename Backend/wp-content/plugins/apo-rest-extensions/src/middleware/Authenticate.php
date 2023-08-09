<?php

namespace apo\rxts\middleware;

use \WP_REST_Server as Server;
use \WP_REST_Request as Request;
use awsm\wp\libraries\utilities\Auth;
use awsm\wp\libraries\interfaces\MiddlewareInterface;
use awsm\wp\libraries\middleware\ApiRoutesMiddleware;

class Authenticate extends ApiRoutesMiddleware implements MiddlewareInterface
{

    use Auth;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        add_filter( 'rest_pre_dispatch', function( $result, Server $server, Request $request ) {
            $route = $request->get_route();

            if( !$this->isOptionsRequest( $request->get_method() ) ) {
                $this->setRoutesByMethod( mb_strtoupper($request->get_method()) );
                // check for public routes, by default are all routes protected

                error_log($route.': '.$this->isPublic($route));

                if( !$this->isPublic($route) && !$this->isLoggedIn() && !$this->isIgnored($route) ) {
                    return $this->unauthorizedRequest();
                }
            }

            return $result;
        }, 10, 3 );
    }

}