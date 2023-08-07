<?php
/*
Plugin Name: Surveys
Plugin URI: https://www.awsm.rocks
Description: Create customer surveys for Apovoice International
Version: 1.0.0
Author: AWESOME! Software GmbH
Author URI:  https://www.awsm.rocks
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: svy
 */


 /**
 * Dont declare a namespace in this file
 * this will come's to conflicts with the wordpress `register_activation_hook` 
 */
use apo\svy\Surveys;
use awsm\wp\loader\ClassLoader;
use apo\svy\Bootstrap;

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Runs only if the plugin is activated
 */
function activate_svy($network_wide) {

    awsm_verifyAutoloader( __FILE__ );

    // Add namespace while the plugin is activated
    ClassLoader::instance()->add('apo\svy', __DIR__ . '/src');

    // Setup all plugin related stuff like database tables on activation
    $survey = new Bootstrap($network_wide);
    $survey->up();
    $survey->surveyManagerRole->create();
}
register_activation_hook( __FILE__, 'activate_svy' );

/**
 * Runs only if the plugin is deactivated
 */
function deactivate_svy($network_wide) {

    // Remove all plugin related stuff
    $survey = new Bootstrap($network_wide);
    $survey->down();
}
register_deactivation_hook( __FILE__, 'deactivate_svy' );

/**
 * Deactivate the plugin if autoloader is missing. 
 * This is truly important to avoid errors and a blank white page.
 */
awsm_deactivatePluginWhenMissingAutoloader(__FILE__, 'Surveys');

/**
 * Only execute the plugin if it is active and autoloader is available
 */
if( awsm_isPluginActiveAndAutoloaderAvailable(__FILE__) ) {
    ClassLoader::instance()->add('apo\svy', __DIR__ . '/src');
    Surveys::instance();
    
}

/**
 * Create plugin related tables if a new blog is created
 */
function onCreateNewBlog( $blogId, $userId, $domain, $path, $siteId, $meta ) {
    if ( is_plugin_active_for_network( plugin_basename(__FILE__) ) ) {
        $surveySetup = new Bootstrap;
        $surveySetup->createTablesForNewBlog($blogId);
    }
}
add_action( 'wpmu_new_blog', 'onCreateNewBlog', 10, 6 );
