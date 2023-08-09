<?php

namespace apo\fuzzysearch\rest\routes;

use \WP_REST_Controller;
use awsm\wp\libraries\utilities\Auth;
use awsm\wp\libraries\interfaces\RegisterableInterface;
use apo\fuzzysearch\controllers\PharmacyFuzzySearchController;
use apo\fuzzysearch\controllers\PharmacyFuzzySearchCreateIndexController;

class PharmaciesFuzzySearch extends WP_REST_Controller implements RegisterableInterface
{
    use Auth;

    const ROUTE_NAMESPACE = 'apovoice';

    const BASE_V1 = 'v1';

    const CURRENT_BASE = self::BASE_V1;

    public function __construct()
    {
        $this->namespace = self::ROUTE_NAMESPACE;
        $this->rest_base = self::CURRENT_BASE;
    }

    public function register()
    {
        awsm_collect_public_routes(self::ROUTE_NAMESPACE . '/' . self::BASE_V1 . '/pharmacies-fuzzy-search');
        $this->registerPharmaciesRoute();
    }

    public function registerPharmaciesRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/pharmacies-fuzzy-search', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => new PharmacyFuzzySearchController,
                    'permission_callback' => function() {
                        return true;
                    },
                ],
            ]
        );
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/pharmacies-fuzzy-search/create-index', [
                [
                    'methods'   => \WP_REST_SERVER::CREATABLE,
                    'callback'    => new PharmacyFuzzySearchCreateIndexController,
                    'permission_callback' => function() {
                        return true;
                    },
                ],
            ]
        );
    }

}
