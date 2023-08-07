<?php
/*
Plugin Name: Apovoice Rest Extensions
Plugin URI: https://www.awsm.rocks
Description: Extends the WordPress REST API with custom endpoints and functionality
Version: 1.0.0
Author: AWESOME! Software GmbH
Author URI:  https://www.awsm.rocks
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: rxts
 */


 /**
 * Dont declare a namespace in this file
 * this will come's to conflicts with the wordpress `register_activation_hook` 
 */
use awsm\wp\loader\ClassLoader;
use apo\rxts\RestExtensions;
use apo\rxts\Bootstrap;

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Runs only if the plugin is activated
 */
function activate_rxts($network_wide) {
    
    awsm_verifyAutoloader(__FILE__);

    // Add namespace while the plugin is activated
    ClassLoader::instance()->add('apo\rxts', __DIR__ . '/src');

    // Setup all plugin related stuff like database tables on activation
    $rxts = new Bootstrap($network_wide);
    $rxts->up();
}
register_activation_hook( __FILE__, 'activate_rxts' );

/**
 * Deactivate the plugin if autoloader is missing. 
 * This is truly important to avoid errors and a blank white page.
 */
awsm_deactivatePluginWhenMissingAutoloader(__FILE__, 'Apovoice Rest Extensions');

/**
 * Only execute the plugin if it is active and autoloader is available
 */
if( awsm_isPluginActiveAndAutoloaderAvailable(__FILE__) ) {
    ClassLoader::instance()->add('apo\rxts', __DIR__ . '/src');
    RestExtensions::instance();
}

/**
 * Create plugin related tables if a new blog is created
 */
function rxts_onCreateNewBlog( $blogId, $userId, $domain, $path, $siteId, $meta ) {
    if ( is_plugin_active_for_network( plugin_basename(__FILE__) ) ) {
        $rxtsSetup = new Bootstrap;
        $rxtsSetup->createTablesForNewBlog($blogId);
    }
}
add_action( 'wpmu_new_blog', 'rxts_onCreateNewBlog', 10, 6 );
