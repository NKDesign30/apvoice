<?php 

namespace apo\rxts\middleware;

use awsm\wp\libraries\interfaces\MiddlewareInterface;

class Cors implements MiddlewareInterface
{

    public function handle()
    {
        add_filter( 'rest_pre_serve_request', function( $served ) {
            $frontendUrl = get_option( 'apo_frontend_url' );
            header( "Access-Control-Allow-Origin: {$frontendUrl}" );
            return $served;
        } );
    }

}