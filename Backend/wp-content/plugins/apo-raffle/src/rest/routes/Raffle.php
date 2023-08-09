<?php

namespace raffle\rest\routes;

use \WP_REST_Controller;
use awsm\wp\libraries\interfaces\RegisterableInterface;
use awsm\wp\libraries\utilities\Auth;
use raffle\controllers\RaffleController;

class Raffle extends WP_REST_Controller implements RegisterableInterface
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
        $this->registerRocksRoute();
        $this->registerRocksPerIdRoute();
    }

    public function registerRocksRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/raffle', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new RaffleController, 'index' ],
                    'permission_callback' => function() {
                        return $this->isLoggedIn();
                    },
                ],
                [
                    'methods'   => \WP_REST_SERVER::EDITABLE,
                    'callback'    => [ new RaffleController, 'store' ],
                    'args' => [
                        'raffle_id' => [
                            'required' => true,
                            'validate_callback' => function($raffleId) {
                                return true;
                            },
                        ],
                        'contest' => [
                            'required' => true,
                            'validate_callback' => function($data) {
                                return true;
                            },
                        ],
                        'lastName' => [
                            'required' => true,
                            'validate_callback' => function($data) {
                                return true;
                            },
                        ],
                        'firstName' => [
                            'required' => true,
                            'validate_callback' => function($data) {
                                return true;
                            },
                        ],
                        'pharmacyCity' => [
                            'required' => true,
                            'validate_callback' => function($data) {
                                return true;
                            },
                        ],
                        'pharmacyName' => [
                            'required' => true,
                            'validate_callback' => function($data) {
                                return true;
                            },
                        ],
                        'pharmacyStreet' => [
                            'required' => true,
                            'validate_callback' => function($data) {
                                return true;
                            },
                        ],
                        'pharmacyCountry' => [
                            'required' => true,
                            'validate_callback' => function($data) {
                                return true;
                            },
                        ],
                        'pharmacyZipCode' => [
                            'required' => true,
                            'validate_callback' => function($data) {
                                return true;
                            },
                        ],
                        'pharmacyStreetNumber' => [
                            'required' => true,
                            'validate_callback' => function($data) {
                                return true;
                            },
                        ]
                    ],
                    'permission_callback' => function() {
                        return true;
                    }
                ]
            ]
        );
    }


    public function registerRocksPerIdRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/raffle/(?P<id>[\d]+)', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new RaffleController, 'show' ],
                    'permission_callback' => function() {
                        return $this->isLoggedIn();
                    },
                ],
            ]
        );
    }
}
