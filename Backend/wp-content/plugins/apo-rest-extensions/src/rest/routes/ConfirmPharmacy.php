<?php 

namespace apo\rxts\rest\routes;

use \WP_REST_Controller;
use awsm\wp\libraries\utilities\Auth;
use apo\rxts\controllers\ConfirmPharmacyController;
use awsm\wp\libraries\interfaces\RegisterableInterface;

class ConfirmPharmacy extends WP_REST_Controller implements RegisterableInterface 
{
    use Auth;

    const ROUTE_NAMESPACE = 'apovoice';

    const BASE_V1 = 'v1';

    const CURRENT_BASE = self::BASE_V1;

    public function __construct()
    {

    }

    public function register()
    {
        $this->registerConfirmPharmacyRoutes();
    }

    public function registerConfirmPharmacyRoutes()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/confirm-pharmacy', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new ConfirmPharmacyController, 'index' ],
                    'permission_callback' => function() {
                        return $this->isLoggedIn();
                    },
                ],
            ]
        );

        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/confirm-pharmacy', [
                [
                    'methods'   => \WP_REST_SERVER::CREATABLE,
                    'callback'    => [ new ConfirmPharmacyController, 'store' ],
                    'permission_callback' => function() {
                        return $this->isLoggedIn() && in_array(get_locale(), ['de_DE', 'de_AT']);
                    },
                ],
            ]
        );
    }
}
