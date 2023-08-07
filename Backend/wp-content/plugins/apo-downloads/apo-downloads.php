<?php
/*
Plugin Name: ApoDownloads
Plugin URI: https://www.awsm.rocks
Description: Manage Downloads for Apovoice Users.
Version: 1.0.0
Author: AWESOME! Software GmbH
Author URI:  https://www.awsm.rocks
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: dwnld
 */


add_filter( 'rest_endpoints', function( $endpoints ){

    if ( ! isset( $endpoints['/wp/v2/downloads'] ) ) {
        return $endpoints;
    }
    unset( $endpoints['/wp/v2/downloads'][0]['args']['per_page']['maximum'] );
    unset( $endpoints['/wp/v2/downloads'][0]['args']['per_page']['minimum'] );
    $endpoints['/wp/v2/downloads'][0]['args']['per_page']['default'] = -1;
    return $endpoints;
});

/**
 * Dont declare a namespace in this file
 * this will come's to conflicts with the wordpress `register_activation_hook` 
 */
use awsm\wp\loader\ClassLoader;
use dwnld\ApoDownloads;
use dwnld\Bootstrap;

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Runs only if the plugin is activated
 */
function activate_dwnld($network_wide) {

    awsm_verifyAutoloader( __FILE__ );

    // Add namespace while the plugin is activated
    ClassLoader::instance()->add('dwnld', __DIR__ . '/src');

    // Setup all plugin related stuff like database tables on activation
    $dwnld = new Bootstrap($network_wide);
    $dwnld->up();
}
register_activation_hook( __FILE__, 'activate_dwnld' );

/**
 * Deactivate the plugin if autoloader is missing. 
 * This is truly important to avoid errors and a blank white page.
 */
awsm_deactivatePluginWhenMissingAutoloader(__FILE__, 'ApoDownloads');

/**
 * Only execute the plugin if it is active and autoloader is available
 */
if( awsm_isPluginActiveAndAutoloaderAvailable(__FILE__) ) {
    ClassLoader::instance()->add('dwnld', __DIR__ . '/src');
    ApoDownloads::instance();   
}

/**
 * Create plugin related tables if a new blog is created
 */
function dwnld_onCreateNewBlog( $blogId, $userId, $domain, $path, $siteId, $meta ) {
    if ( is_plugin_active_for_network( plugin_basename(__FILE__) ) ) {
        $dwnldSetup = new Bootstrap;
        $dwnldSetup->createTablesForNewBlog($blogId);
    }
}
add_action( 'wpmu_new_blog', 'dwnld_onCreateNewBlog', 10, 6 );

