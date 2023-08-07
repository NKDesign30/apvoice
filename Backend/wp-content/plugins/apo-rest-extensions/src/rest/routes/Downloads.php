<?php

namespace apo\rxts\rest\routes;
use \WP_REST_Controller;
use awsm\wp\libraries\utilities\Auth;
use apo\rxts\controllers\DownloadsController;
use awsm\wp\libraries\interfaces\RegisterableInterface;

class Downloads extends WP_REST_Controller implements RegisterableInterface
{

    use Auth;
    
    const ROUTE_NAMESPACE = 'apovoice';

    const BASE_V1 = 'v1';

    const CURRENT_BASE = self::BASE_V1;

    public function __construct()
    {
        awsm_collect_public_routes('apovoice/v1/downloadBundle');
    }

    public function register()
    {
        $this->registerDownloadsRoute();
    }

    public function registerDownloadsRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/downloads/(?P<id>[\d]+)', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new DownloadsController, 'process'],
                    'permission_callback' => function() {
                        return $this->isLoggedIn();
                    },
                ],
            ]
        );
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/registerDownload/(?P<id>[\d]+)', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new DownloadsController, 'register'],
                    'permission_callback' => function() {
                        return $this->isLoggedIn();
                    },
                ],
            ]
        );
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/downloadBundle', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new DownloadsController, 'bundle'],
                    'permission_callback' => function() {
                        return true;
                    },
                ],
            ]
        );
    }
}
