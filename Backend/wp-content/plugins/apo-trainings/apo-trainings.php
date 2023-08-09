<?php
/*
Plugin Name: ApoTrainings
Plugin URI: https://www.awsm.rocks
Description: Create Trainings for Apovoice International Users.
Version: 1.0.0
Author: AWESOME! Software GmbH
Author URI:  https://www.awsm.rocks
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: trng
 */


/**
 * Dont declare a namespace in this file
 * this will come's to conflicts with the wordpress `register_activation_hook` 
 */
use awsm\wp\loader\ClassLoader;
use apo\trng\ApoTrainings;
use apo\trng\Bootstrap;

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Runs only if the plugin is activated
 */
function activate_trng($network_wide) {

    awsm_verifyAutoloader( __FILE__ );

    // Add namespace while the plugin is activated
    ClassLoader::instance()->add('apo\trng', __DIR__ . '/src');

    // Setup all plugin related stuff like database tables on activation
    $trng = new Bootstrap($network_wide);
    $trng->up();
    $trng->trainingManagerRole->create();
}
register_activation_hook( __FILE__, 'activate_trng' );

/**
 * Runs only if the plugin is deactivated
 */
function deactivate_trng($network_wide) {

    // Remove all plugin related stuff
    $trng = new Bootstrap($network_wide);
    $trng->down();
}
register_deactivation_hook( __FILE__, 'deactivate_trng' );

/**
 * Deactivate the plugin if autoloader is missing. 
 * This is truly important to avoid errors and a blank white page.
 */
awsm_deactivatePluginWhenMissingAutoloader(__FILE__, 'ApoTrainings');

/**
 * Only execute the plugin if it is active and autoloader is available
 */
if( awsm_isPluginActiveAndAutoloaderAvailable(__FILE__) ) {
    ClassLoader::instance()->add('apo\trng', __DIR__ . '/src');
    ApoTrainings::instance();   
}

/**
 * Create plugin related tables if a new blog is created
 */
function trng_onCreateNewBlog( $blogId, $userId, $domain, $path, $siteId, $meta ) {
    if ( is_plugin_active_for_network( plugin_basename(__FILE__) ) ) {
        $trngSetup = new Bootstrap;
        $trngSetup->createTablesForNewBlog($blogId);
    }
}
add_action( 'wpmu_new_blog', 'trng_onCreateNewBlog', 10, 6 );

