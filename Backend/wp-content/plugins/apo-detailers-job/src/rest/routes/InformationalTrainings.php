<?php

namespace apo\detailersjob\rest\routes;

use \WP_REST_Controller;
use apo\detailersjob\controllers\InformationalTrainingsController;
use apo\rxts\validation\Rule;
use apo\rxts\validation\Validator;
use awsm\wp\libraries\interfaces\RegisterableInterface;
use awsm\wp\libraries\utilities\Auth;

class InformationalTrainings extends WP_REST_Controller implements RegisterableInterface
{
    use Auth;

    const ROUTE_NAMESPACE = 'detailers-job';

    const BASE_V1 = 'v1';

    const CURRENT_BASE = self::BASE_V1;

    public function __construct()
    {
        $this->namespace = self::ROUTE_NAMESPACE;
        $this->rest_base = self::CURRENT_BASE;
    }

    public function register()
    {
        $this->registerInformationalTrainingsRoute();
    }

    public function registerInformationalTrainingsRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1, '/informational-trainings', [
            [
                'methods'   => \WP_REST_SERVER::READABLE,
                'callback'    => [ new InformationalTrainingsController, 'index' ],
                'permission_callback' => function() {
                    return $this->isLoggedIn();
                },
            ],
            [
                'methods'   => \WP_REST_SERVER::EDITABLE,
                'callback'    => [ new InformationalTrainingsController, 'store' ],
                'args' => Validator::rules([
                    'informational_training_id' => [
                        Rule::required(),
                        Rule::exists( 'posts', 'ID', ['post_type', '=', 'ifrmtnl-trng'] ),
                    ],
                    'pharmacy_id' => [
                        Rule::required(),
                        Rule::exists( 'apovoice_pharmacies', 'id' ),
                    ],
                    'detailer_user_id' => [
                        Rule::required(),
                        Rule::exists( 'users', 'ID' ),
                    ],
                    'last_question_id' => [
                        Rule::required(),
                    ],
                ]),
                'permission_callback' => function() {
                    return $this->isLoggedIn();
                }
            ],
            [
                'methods'   => \WP_REST_SERVER::DELETABLE,
                'callback'    => [ new InformationalTrainingsController, 'destroy' ],
                'args' => Validator::rules([
                    'informational_training_id' => [
                        Rule::required(),
                        Rule::exists( 'posts', 'ID', ['post_type', '=', 'ifrmtnl-trng'] ),
                    ],
                    'pharmacy_id' => [
                        Rule::required(),
                        Rule::exists( 'apovoice_pharmacies', 'id' ),
                    ],
                    'detailer_user_id' => [
                        Rule::required(),
                        Rule::exists( 'users', 'ID' ),
                    ],
                ]),
                'permission_callback' => function() {
                    return $this->isLoggedIn();
                }
            ],
        ]);
    }
}
