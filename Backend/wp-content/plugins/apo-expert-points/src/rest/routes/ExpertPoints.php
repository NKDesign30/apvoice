<?php 

namespace apo\expertpoints\rest\routes;

use \WP_REST_Controller;
use awsm\wp\libraries\utilities\Auth;
use apo\expertpoints\verifier\BaseVerifier;
use awsm\wp\libraries\interfaces\RegisterableInterface;
use apo\expertpoints\controllers\ExpertPointsUserController;

class ExpertPoints extends WP_REST_Controller implements RegisterableInterface 
{

    use Auth;
    
    const ROUTE_NAMESPACE = 'expert-points';

    const BASE_V1 = 'v1';

    const CURRENT_BASE = self::BASE_V1;

    public function __construct()
    {
        $this->namespace = self::ROUTE_NAMESPACE;
        $this->rest_base = self::CURRENT_BASE;
    }

    public function register()
    {
        $this->registerExpertPointsRoute();
    }

    public function registerExpertPointsRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/user', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new ExpertPointsUserController, 'index' ],
                    'permission_callback' => function() {
                        return $this->isLoggedIn();
                    },
                ],
                [
                    'methods'   => \WP_REST_SERVER::EDITABLE,
                    'callback'    => [ new ExpertPointsUserController, 'store' ],
                    'args' => [
                        'user_id' => [
                            'required' => true,
                            'validate_callback' => function($userId) {
                                return (int) $userId === get_current_user_id();
                            },
                        ],
                        'points_earned' => [
                            'required' => false,
                        ],
                        'related_type' => [
                            'required' => true,
                            'validate_callback' => function($relatedType) {
                                return in_array($relatedType, BaseVerifier::ACCEPTED_TYPES );
                            },
                        ],
                        'related_id' => [
                            'required' => true,
                            'validate_callback' => function($relatedId) {
                                return is_numeric($relatedId);
                            },
                        ],
                    ],
                    'permission_callback' => function() {
                        return $this->isLoggedIn();
                    }
                ]
            ]
        );
    }

}
