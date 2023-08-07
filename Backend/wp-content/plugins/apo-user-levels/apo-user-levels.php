<?php
/*
Plugin Name: ApoUserLevels
Plugin URI: https://apovoice.es/
Description: Set user levels by apo points
Version: 1.0.0
Author: ApoVoice
Author URI:  https://apovoice.es/
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: apo_user_levels
 */

// Plugin directory
define('APO_USER_LEVEL_PLUGIN_DIR', plugin_dir_url(__FILE__));

// Add actions
add_action( 'admin_menu', 'apo_user_levels_configuration_page' );
add_action('admin_enqueue_scripts', 'apo_user_levels_configuration_view_enqueue');

// Define rest api
add_action( 'rest_api_init', function () {
    register_rest_route( 'wc/v2', '/user/level', array(
        'methods' => 'GET',
        'callback' => 'apo_user_levels_endpoint',
        'permission_callback' => '__return_true'
    ) );
});

// Add filters
add_filter('posts_where', 'apo_user_levels_posts_where');

// Include functions
require_once __DIR__ . '/functions.php';