<?php

namespace apo\rxts\rest\routes;
use \WP_REST_Controller;
use apo\rxts\controllers\SalesRepExpertCodeController;
use awsm\wp\libraries\interfaces\RegisterableInterface;

class SalesReps extends WP_REST_Controller implements RegisterableInterface
{
    
    const ROUTE_NAMESPACE = 'apovoice';

    const BASE_V1 = 'v1';

    const CURRENT_BASE = self::BASE_V1;

    public function __construct()
    {
        // awsm_collect_public_routes(self::ROUTE_NAMESPACE . '/' . self::BASE_V1 . '/sales-reps/expert-code/');
    }

    public function register()
    {
        $this->registerSalesRepPerExpertCodeRoute();
    }

    public function registerSalesRepPerExpertCodeRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/sales-reps/expert-code/(?P<expert_code>[\w]+)', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new SalesRepExpertCodeController, 'index' ],
                    'permission_callback' => function() {
                        return true;
                    },
                ],
            ]
        );
    }
}
