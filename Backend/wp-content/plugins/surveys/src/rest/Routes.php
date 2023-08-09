<?php 

namespace apo\svy\rest;
use \WP_REST_Controller;
use awsm\wp\libraries\utilities\Auth;
use apo\svy\controllers\ResultsController;
use apo\svy\controllers\ResultsUserController;
use apo\svy\controllers\ResultsSurveyController;
use awsm\wp\libraries\interfaces\RegisterableInterface;

class Routes extends WP_REST_Controller implements RegisterableInterface 
{

    use Auth; 
    
    const ROUTE_NAMESPACE = 'survey-user-results';

    const BASE_V1 = 'v1';

    const CURRENT_BASE = self::BASE_V1;

    public function __construct()
    {
        $this->namespace = 'survey-user-results';
        $this->rest_base = 'v1';
    }

    public function register()
    {
        $this->registerResultsRoute();
        $this->registerResultsPerUserRoute();
        $this->registerResultPerSurveyRoute();
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
                        'survey_id' => [
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

    public function registerResultPerSurveyRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/results/survey/(?P<id>[\d]+)', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new ResultsSurveyController, 'index' ],
                    'permission_callback' => function() {
                        return is_super_admin();
                    },
                ],
            ]
        );
    }
}
