<?php

namespace apo\rxts\rest\routes;

use \WP_REST_Controller;
use awsm\wp\libraries\utilities\Auth;
use apo\rxts\controllers\TrainingQuestionsController;
use awsm\wp\libraries\interfaces\RegisterableInterface;

class TrainingQuestions extends WP_REST_Controller implements RegisterableInterface
{

    use Auth;
    
    const ROUTE_NAMESPACE = 'apovoice';

    const BASE_V1 = 'v1';

    const CURRENT_BASE = self::BASE_V1;

    public function __construct()
    {

    }

    public function register()
    {
        $this->registerTrainingQuestionResultsRoute();
    }

    public function registerTrainingQuestionResultsRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/trainings/questions', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new TrainingQuestionsController, 'index' ],
                    'permission_callback' => function() {
                        return is_super_admin();
                    },
                ],
                [
                    'methods'   => \WP_REST_SERVER::EDITABLE,
                    'callback'    => [ new TrainingQuestionsController, 'store' ],
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
                        'question_id' => [
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
                ],
            ]
        );
    }
}
