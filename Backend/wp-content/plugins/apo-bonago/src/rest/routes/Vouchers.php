<?php 

namespace apo\bonago\rest\routes;

use \WP_REST_Controller;
use awsm\wp\libraries\utilities\Auth;
use apo\bonago\controllers\VouchersController;
use awsm\wp\libraries\interfaces\RegisterableInterface;

class Vouchers extends WP_REST_Controller implements RegisterableInterface 
{

    use Auth;
    
    const ROUTE_NAMESPACE = 'vouchers';

    const BASE_V1 = 'v1';

    const CURRENT_BASE = self::BASE_V1;

    public function __construct()
    {
        $this->namespace = self::ROUTE_NAMESPACE;
        $this->rest_base = self::CURRENT_BASE;
    }

    public function register()
    {
        $this->registerVouchersAssignRoute()
            ->registerVouchersRedeemRoute()
            ->registerVouchersUsersRoute();
    }

    public function registerVouchersAssignRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/assign', [
                [
                    'methods'   => \WP_REST_SERVER::EDITABLE,
                    'callback'    => [ new VouchersController, 'assign' ],
                    'permission_callback' => function() {
                        $permission = true;
                        $user = wp_get_current_user();
                        $is_pending = get_user_meta( $user->ID, 'is_pending', true );
                        
                        $locale = get_locale();

                        if( $is_pending == "1") {
                            $permission = false;
                        }
                        return $this->isLoggedIn() && $permission;
                    }
                ]
            ]
        );

        return $this;
    }

    public function registerVouchersRedeemRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/redeem', [
                [
                    'methods'   => \WP_REST_SERVER::EDITABLE,
                    'callback'    => [ new VouchersController, 'redeem' ],
                    'permission_callback' => function() {
                        $permission = true;
                        $user = wp_get_current_user();
                        $is_pending = get_user_meta( $user->ID, 'is_pending', true );
                        
                        $locale = get_locale();

                        if( $is_pending == "1" ) {
                            $permission = false;
                        }
                        return $this->isLoggedIn() && $permission;
                    }
                ]
            ]
        );

        return $this;
    }

    public function registerVouchersUsersRoute()
    {
        register_rest_route( self::ROUTE_NAMESPACE . '/' . self::BASE_V1  , '/user', [
                [
                    'methods'   => \WP_REST_SERVER::READABLE,
                    'callback'    => [ new VouchersController, 'user' ],
                    'permission_callback' => function() {
                        $permission = true;
                        $user = wp_get_current_user();
                        $is_pending = get_user_meta( $user->ID, 'is_pending', true );
                        
                        $locale = get_locale();

                        if( $is_pending == "1" ) {
                            $permission = false;
                        }
                        return $this->isLoggedIn() && $permission;
                    }
                ]
            ]
        );

        return $this;
    }

}
