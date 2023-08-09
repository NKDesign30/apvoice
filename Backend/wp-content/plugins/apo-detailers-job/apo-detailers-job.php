<?php
/*
Plugin Name: ApoDetailersJob
Plugin URI: https://www.awsm.rocks
Description: Create Informational Trainings for Apovoice International Detailers Job.
Version: 1.0.0
Author: AWESOME! Software GmbH
Author URI:  https://www.awsm.rocks
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: apovoice-detailers-job
 */


/**
 * Dont declare a namespace in this file
 * this will come's to conflicts with the wordpress `register_activation_hook`
 */
use awsm\wp\loader\ClassLoader;
use apo\detailersjob\ApoDetailersJob;
use apo\detailersjob\Bootstrap;

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Runs only if the plugin is activated
 */
function activate_detailers_job($network_wide) {

    awsm_verifyAutoloader( __FILE__ );

    // Add namespace while the plugin is activated
    ClassLoader::instance()->add('apo\detailersjob', __DIR__ . '/src');

    // Setup all plugin related stuff like database tables on activation
    $detailersJob = new Bootstrap($network_wide);
    $detailersJob->up();
    $detailersJob->detailersJobManagerRole->create();
}
register_activation_hook( __FILE__, 'activate_detailers_job' );

/**
 * Runs only if the plugin is deactivated
 */
function deactivate_detailers_job($network_wide) {

    // Remove all plugin related stuff
    $detailersJob = new Bootstrap($network_wide);
    $detailersJob->down();
}
register_deactivation_hook( __FILE__, 'deactivate_detailers_job' );

/**
 * Deactivate the plugin if autoloader is missing.
 * This is truly important to avoid errors and a blank white page.
 */
awsm_deactivatePluginWhenMissingAutoloader(__FILE__, 'ApoDetailersJob');

/**
 * Only execute the plugin if it is active and autoloader is available
 */
if( awsm_isPluginActiveAndAutoloaderAvailable(__FILE__) ) {
    ClassLoader::instance()->add('apo\detailersjob', __DIR__ . '/src');
    ApoDetailersJob::instance();
}

/**
 * Create plugin related tables if a new blog is created
 */
function apovoice_detailers_job_onCreateNewBlog( $blogId, $userId, $domain, $path, $siteId, $meta ) {
    if ( is_plugin_active_for_network( plugin_basename(__FILE__) ) ) {
        $detailersJobSetup = new Bootstrap;
        $detailersJobSetup->createTablesForNewBlog($blogId);
    }
}
add_action( 'wpmu_new_blog', 'apovoice_detailers_job_onCreateNewBlog', 10, 6 );

