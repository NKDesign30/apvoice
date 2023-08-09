<?php

namespace apo\rxts\rest\routes;
use \WP_REST_Controller;
use awsm\wp\libraries\utilities\Auth;
use apo\rxts\controllers\StaticFilesController;
use awsm\wp\libraries\interfaces\RegisterableInterface;

class StaticFiles extends WP_REST_Controller implements RegisterableInterface
{
    const ROUTE_NAMESPACE = 'apovoice';

    const BASE_V1 = 'v1';

    const CURRENT_BASE = self::BASE_V1;

    public function __construct()
    {

    }

    public function register()
    {
        $this->registerStaticFilesRoute();
    }

    public function registerStaticFilesRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/static/(?P<id>[\d]+)', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new StaticFilesController, 'process'],
                    'permission_callback' => function() {
                        return true;
                    },
                ],
            ]
        );
    }
}
