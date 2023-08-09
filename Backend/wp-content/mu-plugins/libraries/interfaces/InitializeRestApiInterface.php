<?php 

namespace awsm\wp\libraries\interfaces;

interface InitializeRestApiInterface
{
    /**
     * Initialize middlewares at rest_api_init wordpdress hook
     * @link https://developer.wordpress.org/reference/hooks/rest_api_init/
     * 
     * @param WP_REST_Server $wp_rest_server
     */
    public function initialize( $wp_rest_server );
}