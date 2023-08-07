<?php

use apo\rxts\utilities\AzureProfileUploader;
use apo\rxts\metaboxes\UserAccessPermissions;

/**
 * Overwrite the default GForm permissions callback
 * This is used to make the /gf/v2/forms endpoint public available
 *
 * @param String $capability The capability required for this endpoint.
 * @param WP_REST_Request $request Full data about the request.
 */
function rxts_gform_rest_api_capability_get_forms($capability, $request) {

	if ($superAdmin = awsm_get_first_super_admin()) {
        wp_set_current_user($superAdmin->id);
    }

	return $capability;
}
add_filter('gform_rest_api_capability_get_forms', 'rxts_gform_rest_api_capability_get_forms', 10, 2);

function rxts_register_user_meta() {
    register_meta( 'user', 'first_name', array(
        'type' => 'string',
        'description' => 'The user\'s first name',
        'single' => true,
        'show_in_rest' => true,
    ) );

    register_meta( 'user', 'last_name', array(
        'type' => 'string',
        'description' => 'The user\'s last name',
        'single' => true,
        'show_in_rest' => true,
    ) );
    
    register_meta( 'user', 'profile_picture', array(
        'type' => 'string',
        'show_in_rest' => array(
            'prepare_callback' => function ( $data ) {
                $profile_pictures = [];

                foreach ( maybe_unserialize( $data ) as $profile_picture ) {
                    $key = 'full';
                    $path = AzureProfileUploader::getUrl($profile_picture);

                    if ( preg_match( '/-(\d+)x\d+\.$/', $profile_picture, $matches ) ) {
                        $key = $matches[1];
                    }

                    $profile_pictures[$key] = $path;
                }

                return $profile_pictures;
            },
        ),
        'single' => true,
    ) );

    register_meta( 'user', 'title', array(
        'type' => 'string',
        'show_in_rest' => true,
        'single' => true,
    ) );

    register_meta( 'user', 'job', array(
        'type' => 'string',
        'show_in_rest' => true,
        'single' => true,
    ) );

    register_meta( 'user', 'form_of_address', array(
        'type' => 'string',
        'show_in_rest' => true,
        'single' => true,
    ) );

    register_meta( 'user', 'working_since', array(
        'type' => 'string',
        'show_in_rest' => true,
        'single' => true,
    ) );

    register_meta( 'user', 'age', array(
        'type' => 'string',
        'show_in_rest' => true,
        'single' => true,
    ) );

    register_meta( 'user', 'expert_only_pharmacies', array(
        'type' => 'string',
        'show_in_rest' => array(
            'prepare_callback' => function ( $data ) {
                return maybe_unserialize( $data );
            },
        ),
        'single' => true,
    ) );

    register_meta( 'user', 'priorities', array(
        'type' => 'string',
        'show_in_rest' => array(
            'prepare_callback' => function ( $data ) {
                return maybe_unserialize( $data );
            },
        ),
        'single' => true,
    ) );

    register_meta( 'user', 'tasks', array(
        'type' => 'string',
        'show_in_rest' => array(
            'prepare_callback' => function ( $data ) {
                return maybe_unserialize( $data );
            },
        ),
        'single' => true,
    ) );

    register_meta( 'user', 'login_dates', array(
        'type' => 'string',
        'show_in_rest' => array(
            'prepare_callback' => function ( $data ) {
                return maybe_unserialize( $data );
            },
        ),
        'single' => true,
    ) );

    register_meta( 'post', 'apo_status', array(
        'type' => 'string',
        'show_in_rest' => array(
            'prepare_callback' => function ( $data ) {
                return maybe_unserialize( $data );
            },
        ),
        'single' => true,
    ) );

    register_meta( 'post', 'apo_user_access_permissions', array(
        'type' => 'string',
        'show_in_rest' => array(
            'prepare_callback' => function ( $data ) {
                return maybe_unserialize( $data );
            },
        ),
        'single' => true,
    ) );
}

add_action( 'rest_api_init', 'rxts_register_user_meta' );


if( !function_exists('rxts_track_user_login_date') ) {
    function rxts_track_user_login_date($data, $user) {
        $loginDates = maybe_unserialize( get_user_meta( $user->ID, 'login_dates', true) );

        if(!is_array($loginDates)) {
            $loginDates = [];
        }

        if(count($loginDates) >= 10) {
            array_shift($loginDates);
        }

        $loginTime = time();
        $loginDates[] = $loginTime;
        update_user_meta( $user->ID, 'login_dates', maybe_serialize($loginDates));
        update_user_meta( $user->ID, 'wfls-last-login', $loginTime);
        return $data;
    }
}
add_filter('jwt_auth_token_before_dispatch', 'rxts_track_user_login_date', 10, 2);

if( !function_exists('rxts_add_has_updated_pharmacy_address_field_to_jwt_response') ) {
    function rxts_add_has_updated_pharmacy_address_field_to_jwt_response($data, $user) {
        if (in_array(get_blog_details(null, false)->path, ['/de/', '/at/'])) {
            $data['has_updated_pharmacy_address'] = rxts_verify_user_has_updated_pharmarcy_address($user->ID);
        }
        return $data;
    }
}
add_filter('jwt_auth_token_before_dispatch', 'rxts_add_has_updated_pharmacy_address_field_to_jwt_response', 10, 2);


if( !function_exists('rxts_filter_user_access_permissions_meta') ) {
    function rxts_filter_user_access_permissions_meta($result, $server, $request) {
        $data = $result->get_data();
        
        if( is_array($data) && 
        count($data) > 0 && 
        array_key_exists('type', $data[0]) && 
        in_array($data[0]['type'], UserAccessPermissions::POST_TYPES) &&
        !is_admin() && 
        !current_user_can('administrator')){

            $roles = (array) wp_get_current_user()->roles;
            
            $data = array_values(array_filter($data, function($item) use ($roles){
                if(!isset($item['meta']) || !isset($item['meta']['apo_user_access_permissions']))
                    return true;
                if(!is_array($item['meta']['apo_user_access_permissions']) || (is_array($item['meta']['apo_user_access_permissions']) && count(array_intersect($item['meta']['apo_user_access_permissions'], $roles)) > 0))
                    return true;
                else
                    return false;
            }));

            $result->set_data($data);
        }

        return $result;
    }
}
add_filter('rest_post_dispatch', 'rxts_filter_user_access_permissions_meta', 10, 3);

if(!function_exists('rxts_set_jwt_auth_expiration_time')) {
    function rxts_set_jwt_auth_expiration_time( $expiresAt, $issuedAt ) {
        return time() + (60 * 30);
    }
}
add_filter('jwt_auth_expire', 'rxts_set_jwt_auth_expiration_time', 10, 2);

if(!function_exists('rxts_verify_user_has_updated_pharmarcy_address')) {
    function rxts_verify_user_has_updated_pharmarcy_address( int $userId ) {
        
        $ignoreMails = Array("@pg.com", "@vmlyrcommerce.com", "@geometry.com");

        $user = get_userdata( $userId );
        if(array_reduce($ignoreMails, function($val, $item) use ($user){
            return $val || (boolean)strpos($user->data->user_email, $item);
        }, false)){
            return true;
        }
        return in_array(get_user_meta( $userId, 'has_updated_pharmacy_address', true), ['1', 'true']) || !in_array(get_locale(), ['de_DE', 'de_AT']);
    }
}

?>
