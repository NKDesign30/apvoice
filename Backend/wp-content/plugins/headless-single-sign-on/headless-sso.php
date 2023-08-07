<?php
/**
* Plugin Name: Headless Single Sign On
* Description: This plugin allows SSO into Headless Single Sign On Plugin
* Version: 1.1.0
* Author: miniOrange
* Author URI: http://miniorange.com
* License: GPL2
*/

require_once('headless-save.php');
require_once('headless-menu-settings.php');
require_once ('includes/Utilities.php');

class headless_sso {

    function __construct(){
        add_action( 'admin_menu', array( $this, 'hsso_menu'),11 );
        add_action( 'admin_init', 'hsso_save_setting', 1, 0 );
        add_action( 'admin_enqueue_scripts', array( $this, 'hsso_plugin_settings_script') );
        register_deactivation_hook(__FILE__, array( $this, 'hsso_deactivate'));
        remove_action( 'admin_notices', array( $this, 'hsso_success_message') );
        remove_action( 'admin_notices', array( $this, 'hsso_error_message') );
        add_action('init',array($this,'hsso_init'));
    }

    function hsso_init(){

        if(array_key_exists('option',$_GET) ){
            $headless_sso =  sanitize_title($_GET['option']);
            if($headless_sso === 'headless_sso')
            {if(is_user_logged_in()){
                $user = wp_get_current_user();
                $token = hsso_create_jwt_token($user);
                $endpoint = get_option('hsso_endpoint');
                $final_endpoint = $endpoint.'?token_type=Bearer&iat='.$token['iat'].'&expires_in='.$token['expires_in'].'&jwt_token='.$token['jwt_token'];
                wp_redirect($final_endpoint);
                exit;
            }
            else{
                auth_redirect();
                exit;
            }}
        }
    }

    function hsso_menu() {
        add_menu_page('Headless Single Sign On','Headless Single Sign On', 'administrator', 'headless_sso', 'hsso',plugin_dir_url(__FILE__) . 'images/miniorange.png');
    }

    function hsso_deactivate() {
        delete_option('hsso_message');
    }

    function hsso_check_option_admin_referer($option_name){
        if(array_key_exists('option',$_POST))
            $option_name_to_be_checked = sanitize_title($_POST['option']);
        return (isset($_POST['option']) and $option_name_to_be_checked==$option_name and check_admin_referer($option_name));
    }

    function hsso_plugin_settings_script($page) {
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-autocomplete');

    }

    function hsso_success_message() {
        $class = "error";
        $message = get_option('hsso_message');
        echo "<div class='" . $class . "'> <p>" . $message . "</p></div>";
    }

    function hsso_error_message() {
        $class = "updated";
        $message = get_option('hsso_message');
        echo "<div class='" . $class . "'><p>" . $message . "</p></div>";
    }


};
new headless_sso;