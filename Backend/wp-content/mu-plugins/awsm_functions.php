<?php

use awsm\wp\libraries\utilities\RoutesCollector;

if(!function_exists('awsm_verifyAutoloader')) {
    function awsm_verifyAutoloader( $file ) {
        if ( !array_key_exists('autoloader.php', get_mu_plugins()) ) {
            deactivate_plugins( plugin_basename( $file ) );
            wp_die( 'To use this plugin, the <b>Autoloader</b> Plugin is required and must be activated' );
        }
    }
}

/**
 * Deactivate the plugin if autoloader is missing. 
 * This is truly important to avoid errors and a blank white page.
 */
if(!function_exists('awsm_deactivatePluginWhenMissingAutoloader')) {
    function awsm_deactivatePluginWhenMissingAutoloader( $file, $pluginName ) {
        if( !array_key_exists('autoloader.php', get_mu_plugins()) ) {
            deactivate_plugins( plugin_basename( $file ) );
            add_action( 'network_admin_notices',  function() use ($pluginName) {
                echo '<div class="notice notice-error"><p>The plugin <b>' . $pluginName . '</b> was deactivated because the autoloader plugin is missing</p></div>';
            });
        }
    }
}

/**
 * Only execute the plugin if it is active and autoloader is available
 */
if(!function_exists('awsm_isPluginActiveAndAutoloaderAvailable')) {
    function awsm_isPluginActiveAndAutoloaderAvailable( $file ) {
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        if ( is_plugin_active( plugin_basename( $file ) ) && array_key_exists('autoloader.php', get_mu_plugins()) ) {
            return true;
        }
        return false;
    }
}

/**
 * Used as a global helper function to resolve the RoutesCollector
 * and calls collectRouteNamespace method
 * 
 * @param string|array $routes 
 * @param array $methods http verbs
 */
if(!function_exists('awsm_collect_route_namespaces')) {
    function awsm_collect_route_namespaces( $routes, $methods = [] ) {
        RoutesCollector::instance()->collectRouteNamespace($routes, $methods);
    }
}

/**
 * Used as a global helper function to resolve the RoutesCollector
 * and calls collectPublicRoutes method
 * 
 * @param string|array $routes 
 * @param array $methods http verbs
 */
if(!function_exists('awsm_collect_public_routes')) {
    function awsm_collect_public_routes( $routes, $methods = [] ) {
        RoutesCollector::instance()->collectPublicRoute($routes, $methods);
    }
}

/**
 * Used as a global helper function to resolve the RoutesCollector
 * and calls collectProtectedRoute method
 * 
 * @param string|array $routes 
 * @param array $methods http verbs
 */
if(!function_exists('awsm_collect_protected_routes')) {
    function awsm_collect_protected_routes( $routes, $methods = [] ) {
        RoutesCollector::instance()->collectProtectedRoute($routes, $methods);
    }
}

/**
 * Used as a global helper function to resolve the RoutesCollector
 * and calls collectAdminRoute method
 * 
 * @param string|array $routes 
 * @param array $methods http verbs
 */
if(!function_exists('awsm_collect_admin_routes')) {
    function awsm_collect_admin_routes( $routes, $methods = [] ) {
        RoutesCollector::instance()->collectAdminRoute($routes, $methods);
    }
}

/**
 * Checks if the provided string starts with the given character
 * 
 * @param string $str 
 * @param string $char
 * 
 * @return boolean
 */
if(!function_exists('awsm_strings_starts_with')) {
    function awsm_strings_starts_with( $str, $char ) {
        return $str[0] === $char;
    }
}

if(!function_exists('generateRandomString')) {
    function generateRandomString($length = 6) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if(!function_exists('awsm_modify_cache_data')) {
    function awsm_modify_cache_data( $cache ) {
        $data = $cache['data'];

        if( is_array($data) && 
        count($data) > 0 && 
        array_key_exists('type', $data[0]) && 
        in_array($data[0]['type'], array( 'surveys' ))){
        
            global $wpdb;

            $sql = $wpdb->prepare( "
                SELECT
                    *
                FROM
                    `{$wpdb->prefix}training_user_results`
                WHERE
                    `user_id` = %d AND
                    `is_complete` = 1
            ", 
                get_current_user_id()
            );
        
            $trainings = $wpdb->get_results( $sql );
            $data = array_filter($data, function($item) use ($trainings) {
                if( !key_exists('training_relation', $item['acf']) || 
                    (boolean) !$item['acf']['training_relation']['activatable'] ) {
                    return true;
                }

                foreach($trainings as $training){
                    if($training->training_id == $item['acf']['training_relation']['training']){
                        return true;
                    }
                }
                return false;
            });

            $cache['data'] = array_values($data);
        }

        return $cache;
    }
}
add_filter('wp_rest_cache/pre_send_data', 'awsm_modify_cache_data', 10, 1);

if(!function_exists('awsm_modify_cache_header')) {
    function awsm_modify_cache_header( $header ) {

        if(is_user_logged_in())
            $header['roles'] = implode(',',(array) wp_get_current_user()->roles);

        return $header;
    }
}
add_filter('wp_rest_cache/pre_get_cache', 'awsm_modify_cache_header', 10, 1);


if( !function_exists('awsm_check_user_login_roles') ) {
    function awsm_check_user_login_roles($data, $user) {

        if(boolVal(get_option( 'apo_maintanance' ))){
            if(!in_array("administrator", $user->roles)){
                return new WP_Error(
                    '[jwt_auth] maintanance',
                    __('Maintenance work is currently being carried out.', 'rxts'),
                    array(
                        'status' => 403,
                    )
                );
            }
        }

        if(in_array("blocked", $user->roles)){
            return new WP_Error(
                '[jwt_auth] blocked_user',
                __('Your Account has been blocked. Contact Support for more information.', 'rxts'),
                array(
                    'status' => 403,
                )
            );
        }

        if(in_array("request", $user->roles)){
            return new WP_Error(
                '[jwt_auth] disabled_user',
                __('Your Account currently disabled. Contact Support for more information.', 'rxts'),
                array(
                    'status' => 403,
                )
            );
        }

        return $data;
    }
}
add_filter('jwt_auth_token_before_dispatch', 'awsm_check_user_login_roles', 11, 2);


if( !function_exists('awsm_custom_user_columns') ) {
    function awsm_custom_user_columns($value = '', $column_name = '', $user_id = 0) {
        if ( 'wfls_last_login' == $column_name ){
            $loginDates = maybe_unserialize( get_user_meta( $user_id, 'login_dates', true) );
            
            if(is_array($loginDates) && count($loginDates) > 0){
                return date_i18n(get_option( 'date_format' ), $loginDates[count($loginDates)-1]);
            }
        }
        return $value;
    }
}
add_filter('manage_users_custom_column', 'awsm_custom_user_columns', 100, 3);

/**
 * Return the first found super admin user
 * 
 * @return \WP_User|false
 */
if(!function_exists('awsm_get_first_super_admin')) {
    function awsm_get_first_super_admin() {

        if( empty($superAdmins = get_super_admins())) {
            return null;
        }

        // reset array keys, because it doesn't start always at zero index
        $firstAdmin = array_values($superAdmins)[0];

        if (filter_var($firstAdmin, FILTER_VALIDATE_EMAIL) === false) {
            return get_user_by('login', $firstAdmin);
        }

        return get_user_by('email', $firstAdmin);

    }
}
