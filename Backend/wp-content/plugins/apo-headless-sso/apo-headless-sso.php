<?php

/**
 * Plugin Name: Headless Single Sign On ES
 * Description: This plugin allows SSO into Headless Single Sign On Plugin
 * Version: 1.0.0
 * Author: NK Design
 * Author URI: https://www.design-nk.de/
 * License: GPL2
 */

add_action('init', function() {
    if(!session_id()) {
        session_start();
    }

    if (is_home()) {
        wp_redirect(get_admin_url() . '?option=apo-sso'); exit;
    }

    if (array_key_exists('option',$_GET) ) {
        $headless_sso = sanitize_title($_GET['option']);

        if ($headless_sso === 'apo-saml') {
            if (!empty($_SERVER['HTTP_REFERER'])) {
                $_SESSION['apo-saml'] = $_SERVER['HTTP_REFERER'];
            }
            wp_redirect(admin_url() . '?option=saml_user_login');
            exit;
        }
    }

    if(array_key_exists('option',$_GET) ) {
        $headless_sso = sanitize_title($_GET['option']);

        if ($headless_sso === 'apo-sso') {
            if (is_user_logged_in()) {

                $user = wp_get_current_user();
                $blogId = get_user_meta($user->data->ID)['primary_blog'][0];

                $issuedAt = time();
                $notBefore = apply_filters('jwt_auth_not_before', $issuedAt, $issuedAt);
                $expire = apply_filters('jwt_auth_expire', $issuedAt + (DAY_IN_SECONDS * 7), $issuedAt);

                $token = array(
                    'iss' => get_bloginfo('url'),
                    'iat' => $issuedAt,
                    'nbf' => $notBefore,
                    'exp' => $expire,
                    'data' => array(
                        'user' => array(
                            'pass' => $user->data->user_pass,
                            'id' => $user->data->ID,
                        ),
                    ),
                );

                $secret_key = defined('JWT_AUTH_SECRET_KEY') ? JWT_AUTH_SECRET_KEY : false;
                $token = \Firebase\JWT\JWT::encode(apply_filters('jwt_auth_token_before_sign', $token, $user), $secret_key);

                switch_to_blog($blogId);
                $endpoint = get_option( 'apo_frontend_url' );
                error_log("Frontend URL" . $endpoint);
                /*$endpoint =  'https://apovoice.es';*/
                /*$endpoint = get_option('app_frontend_url') ?? 'https://backend.apovoice.es/?option=apo-sso';*/
                restore_current_blog();

                if (!empty($_SESSION['apo-saml'])) {

                    $endpoint = $_SESSION['apo-saml'];
                    unset($_SESSION['apo-saml']);
                }
                $final_endpoint = $endpoint . '?token_type=Bearer&iat=' . $issuedAt . '&expires_in=' . $expire . '&jwt_token=' . urlencode($token);

                wp_redirect($final_endpoint);
                exit;
            } else {
                wp_redirect(get_option('hsso_endpoint'));
                exit;
            }
        }
    }
});