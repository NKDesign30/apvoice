<?php 

namespace apo\reporting\rest\routes;

use \WP_REST_Controller;
use apo\reporting\controllers\ReportingController;
use awsm\wp\libraries\interfaces\RegisterableInterface;

class Reporting extends WP_REST_Controller implements RegisterableInterface 
{

    const ROUTE_NAMESPACE = 'apovoice';

    const BASE_V1 = 'v1';

    const CURRENT_BASE = self::BASE_V1;

    public function __construct()
    {
        awsm_collect_public_routes(self::ROUTE_NAMESPACE . '/' . self::BASE_V1 . '/reporting');
        awsm_collect_public_routes(self::ROUTE_NAMESPACE . '/' . self::BASE_V1 . '/reporting-total-hcps');
        awsm_collect_public_routes(self::ROUTE_NAMESPACE . '/' . self::BASE_V1 . '/reporting-new-hcps');
        awsm_collect_public_routes(self::ROUTE_NAMESPACE . '/' . self::BASE_V1 . '/reporting-new-hcps-timeline');
        awsm_collect_public_routes(self::ROUTE_NAMESPACE . '/' . self::BASE_V1 . '/reporting-tranings-hcps-completion-rate');
        awsm_collect_public_routes(self::ROUTE_NAMESPACE . '/' . self::BASE_V1 . '/reporting-tranings-in-details');
    }

    public function register()
    {
        $this->registerReportingRoute();
    }

    public function registerReportingRoute()
    {
        // Reporting Index
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/reporting(?:/(?P<date>[a-zA-Z0-9_-]+))?', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new ReportingController, 'index' ],
                    'permission_callback' => function() {
                        return true;
                    },
                ],
            ]
        );

        // Reporting Total HCPs
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/reporting-total-hcps(?:/(?P<date>[a-zA-Z0-9_-]+))?', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new ReportingController, 'totalHCPs' ],
                    'permission_callback' => function() {
                        return true;
                    },
                ],
            ]
        );

        // Reporting New HCPs
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/reporting-new-hcps(?:/(?P<date>[a-zA-Z0-9_-]+))?', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new ReportingController, 'newRegisteredHCPs' ],
                    'permission_callback' => function() {
                        return true;
                    },
                ],
            ]
        );

        // Reporting New HCPs with Timeline
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/reporting-new-hcps-timeline(?:/(?P<date>[a-zA-Z0-9_-]+))?', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new ReportingController, 'newRegisteredHCPsTimeline' ],
                    'permission_callback' => function() {
                        return true;
                    },
                ],
            ]
        );

        // Reporting Tranins HCPs Completion Rate
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/reporting-tranings-hcps-completion-rate(?:/(?P<date>[a-zA-Z0-9_-]+))?', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new ReportingController, 'traningsHCPsCompletionRate' ],
                    'permission_callback' => function() {
                        return true;
                    },
                ],
            ]
        );

        // Reporting Tranins in Details
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/reporting-tranings-in-details(?:/(?P<date>[a-zA-Z0-9_-]+))?', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new ReportingController, 'traningsInDetails' ],
                    'permission_callback' => function() {
                        return true;
                    },
                ],
            ]
        );
    }
}
