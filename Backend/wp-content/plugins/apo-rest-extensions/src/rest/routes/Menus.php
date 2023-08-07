<?php 

namespace apo\rxts\rest\routes;
use \WP_REST_Controller;
use awsm\wp\libraries\utilities\Auth;
use apo\rxts\controllers\MenusController;
use awsm\wp\libraries\interfaces\RegisterableInterface;

class Menus extends WP_REST_Controller implements RegisterableInterface 
{

    use Auth;
    
    const ROUTE_NAMESPACE = 'apovoice';

    const BASE_V1 = 'v1';

    const CURRENT_BASE = self::BASE_V1;

    public function __construct()
    {
        awsm_collect_public_routes(self::ROUTE_NAMESPACE . '/' . self::BASE_V1 . '/menus');
    }

    public function register()
    {
        $this->registerMenusRoute();
        $this->registerMenuPerIdRoute();
        $this->registerMenuPerLocationSlugRoute();
    }

    public function registerMenusRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/menus', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new MenusController, 'index' ],
                    'permission_callback' => function() {
                        return true;
                    },
                ],
            ]
        );
    }

    public function registerMenuPerIdRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/menus/(?P<id>[\d]+)', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new MenusController, 'show' ],
                    'permission_callback' => function () {
                        return $this->isLoggedIn();
                    },
                ],
            ]
        );
    }

    public function registerMenuPerLocationSlugRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/menus/(?P<slug>[a-zA-Z0-9_-]+)', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new MenusController, 'showByLocationSlug' ],
                    'permission_callback' => function () {
                        return $this->isLoggedIn();
                    },
                ],
            ]
        );
    }
}
