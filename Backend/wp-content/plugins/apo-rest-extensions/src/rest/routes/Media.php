<?php

namespace apo\rxts\rest\routes;
use \WP_REST_Controller;
use apo\rxts\controllers\MediaController;
use awsm\wp\libraries\interfaces\RegisterableInterface;

class Media extends WP_REST_Controller implements RegisterableInterface
{
   
    const ROUTE_NAMESPACE = 'apovoice';

    const BASE_V1 = 'v1';

    const CURRENT_BASE = self::BASE_V1;

    public function __construct()
    {
        awsm_collect_public_routes(self::ROUTE_NAMESPACE . '/' . self::BASE_V1 . '/media');
    }

    public function register()
    {
        $this->registerMediaRoute();
    }

    public function registerMediaRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/media(?:/(?P<path>[a-zA-Z0-9_-]+))?', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new MediaController, 'process'],
                    'permission_callback' => function() {
                        return true;
                    },
                ],
            ]
        );
    }
}
