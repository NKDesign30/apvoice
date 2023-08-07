<?php 

namespace dwnld\rest\routes;

use \WP_REST_Controller;
use awsm\wp\libraries\utilities\Auth;
use awsm\wp\libraries\interfaces\RegisterableInterface;
use dwnld\controllers\DownloadsController;

class Downloads extends WP_REST_Controller implements RegisterableInterface 
{

    use Auth;

    const ROUTE_NAMESPACE = 'apovoice';

    const BASE_V1 = 'v1';

    const CURRENT_BASE = self::BASE_V1;

    public function __construct()
    {
        $this->namespace = self::ROUTE_NAMESPACE;
        $this->rest_base = self::CURRENT_BASE;
        awsm_collect_public_routes('wp/v2/dwnld-category');
        awsm_collect_public_routes('wp/v2/dwnld-product');
        awsm_collect_public_routes('wp/v2/dwnld-mediatype');
        awsm_collect_public_routes('wp/v2/downloads');
        awsm_collect_public_routes('wp/v2/pages');
    }

    public function register()
    {
        $this->registerDownloadsRoute();
        $this->registerDownloadsPerIdRoute();
    }

    public function registerDownloadsRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/downloads', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new DownloadsController, 'index' ],
                    'permission_callback' => function() {
                        return $this->isLoggedIn();
                    },
                ]
            ]
        );
    }


    public function registerDownloadsPerIdRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/downloads/(?P<id>[\d]+)', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new DownloadsController, 'show' ],
                    'permission_callback' => function() {
                        return $this->isLoggedIn();
                    },
                ],
            ]
        );
    }
}
