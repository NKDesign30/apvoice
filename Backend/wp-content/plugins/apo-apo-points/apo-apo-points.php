<?php
/*
Plugin Name: Apo_ApoPoints
Plugin URI: https://www.awsm.rocks
Description: Manage Expert Points for Apovoice
Version: 1.0.0
Author: AWESOME! Software GmbH
Author URI:  https://www.awsm.rocks
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: apo_apopoints
 */


/**
 * Dont declare a namespace in this file
 * this will come's to conflicts with the wordpress `register_activation_hook` 
 */
use awsm\wp\loader\ClassLoader;
use apo\apopoints\ApoApoPoints;
use apo\apopoints\Bootstrap;

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Runs only if the plugin is activated
 */
function activate_apo_apopoints($network_wide) {

    awsm_verifyAutoloader( __FILE__ );

    // Add namespace while the plugin is activated
    ClassLoader::instance()->add('apo\apopoints', __DIR__ . '/src');

    // Setup all plugin related stuff like database tables on activation
    $apo_apopoint = new Bootstrap($network_wide);
    $apo_apopoint->up();
}
register_activation_hook( __FILE__, 'activate_apo_apopoints' );

/**
 * Deactivate the plugin if autoloader is missing. 
 * This is truly important to avoid errors and a blank white page.
 */
awsm_deactivatePluginWhenMissingAutoloader(__FILE__, 'ApoApoPoints');

/**
 * Only execute the plugin if it is active and autoloader is available
 */
if( awsm_isPluginActiveAndAutoloaderAvailable(__FILE__) ) {
    ClassLoader::instance()->add('apo\apopoints', __DIR__ . '/src');
    ApoApoPoints::instance();
}

/**
 * Create plugin related tables if a new blog is created
 */
function apo_apopoints_onCreateNewBlog( $blogId, $userId, $domain, $path, $siteId, $meta ) {
    if ( is_plugin_active_for_network( plugin_basename(__FILE__) ) ) {
        $apo_apopointSetup = new Bootstrap;
        $apo_apopointSetup->createTablesForNewBlog($blogId);
    }
}
add_action( 'wpmu_new_blog', 'apo_apopoints_onCreateNewBlog', 10, 6 );

