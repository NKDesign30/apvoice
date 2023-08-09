<?php

namespace apo\rxts\rest\routes;
use \WP_REST_Controller;
use awsm\wp\libraries\utilities\Auth;
use apo\rxts\controllers\PharmaciesController;
use awsm\wp\libraries\interfaces\RegisterableInterface;

class Pharmacies extends WP_REST_Controller implements RegisterableInterface
{

    use Auth;
    const ROUTE_NAMESPACE = 'apovoice';

    const BASE_V1 = 'v1';

    const CURRENT_BASE = self::BASE_V1;

    public function __construct()
    {
        //awsm_collect_public_routes(self::ROUTE_NAMESPACE . '/' . self::BASE_V1 . '/pharmacies');
    }

    public function register()
    {
        $this->registerPharmaciesRoute();
    }

    public function registerPharmaciesRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/pharmacies/(?P<id>[\w]+)', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new PharmaciesController, 'index' ],
                    'permission_callback' => function() {
                        return true;
                    },
                ],
            ]
        );
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/pharmacies', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new PharmaciesController, 'index' ],
                    'permission_callback' => function() {
                        return true;
                    },
                ],
            ]
        );
    }
}
