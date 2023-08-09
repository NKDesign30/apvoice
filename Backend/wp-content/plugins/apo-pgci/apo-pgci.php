<?php
/*
Plugin Name: ApoPgci
Plugin URI: https://www.awsm.rocks
Description: Manage P&G customer ids for Apovoice.
Version: 1.0.0
Author: AWESOME! Software GmbH
Author URI:  https://www.awsm.rocks
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: apo-pgci
 */


/**
 * Dont declare a namespace in this file
 * this will come's to conflicts with the wordpress `register_activation_hook`
 */
use awsm\wp\loader\ClassLoader;
use apo\pgci\ApoPgci;
use apo\pgci\Bootstrap;

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Runs only if the plugin is activated
 */
function activate_apo_pgci( $network_wide ) {
    awsm_verifyAutoloader( __FILE__ );

    // Add namespace while the plugin is activated
    ClassLoader::instance()->add( 'apo\pgci', __DIR__ . '/src' );

    // Setup all plugin related stuff like database tables on activation
    $pgci = new Bootstrap($network_wide);
    $pgci->up();
    $pgci->createRoles();
}
register_activation_hook( __FILE__, 'activate_apo_pgci' );

/**
 * Runs only if the plugin is deactivated
 */
function deactivate_apo_pgci($network_wide) {

    // Remove all plugin related stuff
    $pgci = new Bootstrap($network_wide);
    $pgci->down();
}
register_deactivation_hook( __FILE__, 'deactivate_apo_pgci' );

/**
 * Deactivate the plugin if autoloader is missing.
 * This is truly important to avoid errors and a blank white page.
 */
awsm_deactivatePluginWhenMissingAutoloader( __FILE__, 'ApoPgci' );

/**
 * Only execute the plugin if it is active and autoloader is available
 */
if( awsm_isPluginActiveAndAutoloaderAvailable( __FILE__ ) ) {
    ClassLoader::instance()->add( 'apo\pgci', __DIR__ . '/src' );
    ApoPgci::instance();
}

/**
 * Create plugin related tables if a new blog is created
 */
function apo_pgci_on_create_new_blog( $blogId, $userId, $domain, $path, $siteId, $meta ) {
    if ( is_plugin_active_for_network( plugin_basename( __FILE__ ) ) ) {
        $pgciSetup = new Bootstrap;
        $pgciSetup->createTablesForNewBlog($blogId);
    }
}
add_action( 'wpmu_new_blog', 'apo_pgci_on_create_new_blog', 10, 6 );

