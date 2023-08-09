<?php 

namespace apo\trng\rest\routes;

use \WP_REST_Controller;
use awsm\wp\libraries\utilities\Auth;
use apo\trng\controllers\ResultsController;
use apo\trng\controllers\ResultsUserController;
use apo\trng\controllers\ResultsTrainingController;
use awsm\wp\libraries\interfaces\RegisterableInterface;

class Results extends WP_REST_Controller implements RegisterableInterface 
{

    use Auth;
    
    const ROUTE_NAMESPACE = 'training-user-results';

    const BASE_V1 = 'v1';

    const CURRENT_BASE = self::BASE_V1;

    public function __construct()
    {
        $this->namespace = self::ROUTE_NAMESPACE;
        $this->rest_base = self::CURRENT_BASE;
    }

    public function register()
    {
        $this->registerResultsRoute();
        $this->registerResultsPerUserRoute();
        $this->registerResultPerTrainingRoute();
    }

    public function registerResultsRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/results', [
            [
                'methods'   => \WP_REST_SERVER::READABLE,
                'callback'    => [ new ResultsController, 'index' ],
                'permission_callback' => function() {
                    return is_super_admin();
                },
            ],
            [
                'methods'   => \WP_REST_SERVER::EDITABLE,
                'callback'    => [ new ResultsController, 'store' ],
                'args' => [
                    'user_id' => [
                        'required' => true,
                        'validate_callback' => function($userId) {
                            return (int) $userId === get_current_user_id();
                        },
                    ],
                    'training_id' => [
                        'required' => true,
                    ],
                    'lesson_id' => [
                        'required' => true,
                    ],
                    'result' => [
                        'sanitize_callback' => function($param) {
                            return maybe_serialize($param);
                        }
                    ]
                ],
                'permission_callback' => function() {
                    return $this->isLoggedIn();
                }
            ]
        ]
    );
    }


    public function registerResultsPerUserRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/results/user', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new ResultsUserController, 'index' ],
                    'permission_callback' => function() {
                        return is_super_admin();
                    },
                ],
            ]
        );
    }

    public function registerResultPerTrainingRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/results/training/(?P<id>[\d]+)', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new ResultsTrainingController, 'index' ],
                    'permission_callback' => function() {
                        return is_super_admin();
                    },
                ],
            ]
        );

        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/registerTrainingParticipation/(?P<training_id>[\d]+)', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new ResultsTrainingController, 'registerParticipation' ],
                    'permission_callback' => function() {
                        return $this->isLoggedIn();
                    },
                ],
            ]
        );
    }
}
