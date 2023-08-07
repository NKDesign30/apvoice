<?php

namespace apo\rxts\rest\routes;
use \WP_REST_Controller;
use apo\rxts\validation\Rule;
use apo\rxts\validation\Validator;
use awsm\wp\libraries\utilities\Auth;
use apo\rxts\controllers\UsersController;
use apo\rxts\controllers\UserProfilesController;
use awsm\wp\libraries\interfaces\RegisterableInterface;

class Users extends WP_REST_Controller implements RegisterableInterface
{

    use Auth;
    
    const ROUTE_NAMESPACE = 'apovoice';

    const BASE_V1 = 'v1';

    const CURRENT_BASE = self::BASE_V1;

    public function __construct()
    {
        awsm_collect_public_routes(self::ROUTE_NAMESPACE . '/' . self::BASE_V1 . '/users/activate');
        awsm_collect_public_routes(self::ROUTE_NAMESPACE . '/' . self::BASE_V1 . '/users/confirmmail');
    }

    public function register()
    {
        $this->registerUsersRoute();
    }

    public function registerUsersRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1, '/users/activate', [
                [
                    'methods'   => \WP_REST_SERVER::CREATABLE,
                    'callback'    => [ new UsersController, 'activate' ],
                    'permission_callback' => function() {
                        return true;
                    },
                ],
            ]
        );

        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1, '/users/confirmmail', [
                [
                    'methods'   => \WP_REST_SERVER::CREATABLE,
                    'callback'    => [ new UsersController, 'confirmmail' ],
                    'permission_callback' => function() {
                        return true;
                    },
                ],
            ]
        );

        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1, '/users/acceptNewsletter', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new UsersController, 'acceptNewsletter' ],
                    'permission_callback' => function() {
                        return true;
                    },
                ],
            ]
        );

        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1, '/users/(?P<id>[\d]+)/profile', [
            [
                'methods'   => \WP_REST_SERVER::EDITABLE,
                'callback'  => [ new UserProfilesController, 'update' ],
                'permission_callback' => function () {
                    return $this->isLoggedIn();
                },
                'args' => Validator::rules([
                    'account_email' => [
                        Rule::required(),
                        Rule::email(),
                        Rule::unique( 'users', 'user_email', get_current_user_id() ),
                    ],
                    'account_new_email' => [
                        Rule::sometimes(),
                        Rule::email(),
                        Rule::unique( 'users', 'user_email', get_current_user_id() ),
                        Rule::confirmed(),
                    ],
                    'account_password' => [
                        Rule::sometimes(),
                        Rule::nullable(),
                        Rule::min( 8 ),
                        Rule::confirmed(),
                    ],
                    'associated_pharmacies' => [
                        Rule::required(),
                        Rule::isArray(),
                        Rule::min( 1 ),
                        // TODO: Add rule for validating all array items
                    ],
                    'age' => [
                        Rule::sometimes(),
                        Rule::nullable(),
                    ],
                    'first_name' => [
                        Rule::required(),
                    ],
                    'form_of_address' => [
                        Rule::sometimes(),
                        Rule::nullable(),
                        Rule::in( [
                            'mr',
                            'mrs',
                        ] ),
                    ],
                    'last_name' => [
                        Rule::required(),
                    ],
                    'job' => [
                        Rule::sometimes(),
                        Rule::nullable(),
                    ],
                    'other_priorities' => [
                        Rule::requiredIf( function ( $param, $request, $key ) {
                            return in_array( 'others', $request->get_param( 'priorities' ) );
                        } ),
                    ],
                    'priorities' => [
                        Rule::sometimes(),
                        Rule::isArray(),
                        // TODO: Add rule for validating all array items
                    ],
                    'tasks' => [
                        Rule::sometimes(),
                        Rule::isArray(),
                        // TODO: Add rule for validating all array items
                    ],
                    'expert_only_pharmacies' => [
                        Rule::sometimes(),
                        // TODO: Add rule for validating all array items
                    ],
                    'title' => [
                        Rule::sometimes(),
                        Rule::nullable(),
                        Rule::in( [
                            'dr.dr.',
                            'dr.med.dent.',
                        ] ),
                    ],
                    'working_since' => [
                        Rule::sometimes(),
                        Rule::nullable(),
                        Rule::dateFormat( 'Y' ),
                    ],
                ]),
            ],
        ] );
    }
}
