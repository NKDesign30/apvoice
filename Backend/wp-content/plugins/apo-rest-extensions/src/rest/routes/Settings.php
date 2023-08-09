<?php 

namespace apo\rxts\rest\routes;
use \WP_REST_Controller;
use awsm\wp\libraries\utilities\Auth;
use apo\rxts\controllers\SettingsController;
use awsm\wp\libraries\interfaces\RegisterableInterface;

class Settings extends WP_REST_Controller implements RegisterableInterface 
{

    use Auth;
    
    const ROUTE_NAMESPACE = 'apovoice';

    const BASE_V1 = 'v1';

    const CURRENT_BASE = self::BASE_V1;

    public function __construct()
    {
        awsm_collect_public_routes(self::ROUTE_NAMESPACE . '/' . self::BASE_V1 . '/settings');
    }

    public function register()
    {
        $this->registerSettingsRoute();
        $this->registerSettingsFormLocationsRoute();
    }

    public function registerSettingsRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/settings', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new SettingsController, 'index' ],
                    'permission_callback' => function() {
                        return true;
                    },
                ],
            ]
        );
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/settings/invitation/create', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new SettingsController, 'createInvitations' ],
                    'permission_callback' => function() {
                        return true;
                    },
                ],
            ]
        );
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/settings/job-roles', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new SettingsController, 'jobRoles' ],
                    'permission_callback' => function() {
                        return true;
                    },
                ],
            ]
        );
    }

    public function registerSettingsFormLocationsRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/settings/form-locations', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new SettingsController, 'formLocations' ],
                    'permission_callback' => function () {
                        return $this->isLoggedIn();
                    },
                ],
            ]
        );
    }
}
