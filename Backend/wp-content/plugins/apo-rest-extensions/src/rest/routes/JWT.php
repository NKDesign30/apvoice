<?php

namespace apo\rxts\rest\routes;
use \WP_REST_Controller;
use awsm\wp\libraries\utilities\Auth;
use apo\rxts\controllers\JWTAuthController;
use awsm\wp\libraries\interfaces\RegisterableInterface;

class JWT extends WP_REST_Controller implements RegisterableInterface
{

    use Auth;
    
    const ROUTE_NAMESPACE = 'jwt-auth';

    const BASE_V1 = 'v1';

    const CURRENT_BASE = self::BASE_V1;

    public function __construct()
    {

    }

    public function register()
    {
        $this->registerRefreshRoute();
    }

    public function registerRefreshRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/token/refresh', [
                [
                    'methods'   => \WP_REST_SERVER::CREATABLE,
                    'callback'    => [ new JWTAuthController, 'refresh'],
                    'permission_callback' => function() {
                        return $this->isLoggedIn();
                    },
                ],
            ]
        );
    }
}
