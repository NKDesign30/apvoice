<?php

namespace apo\rxts\rest\routes;
use \WP_REST_Controller;
use awsm\wp\libraries\utilities\Auth;
use apo\rxts\controllers\PageUserRolePermissionsController;
use awsm\wp\libraries\interfaces\RegisterableInterface;

class PagePermissions extends WP_REST_Controller implements RegisterableInterface
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
        $this->registerPageUserRolePermissionsRoute();
    }

    public function registerPageUserRolePermissionsRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/page-permissions', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new PageUserRolePermissionsController, 'index'],
                    'permission_callback' => function() {
                        return $this->isLoggedIn();
                    },
                ],
            ]
        );
    }
}
