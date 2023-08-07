<?php
/*
Plugin Name: ApoFuzzySearch
Plugin URI: https://www.awsm.rocks
Description: Provides a fuzzy search for pharmacies
Version: 1.0.0
Author: AWESOME! Software GmbH
Author URI:  https://www.awsm.rocks
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: apo_fuzzy_search
 */


/**
 * Dont declare a namespace in this file
 * this will come's to conflicts with the wordpress `register_activation_hook` 
 */
use awsm\wp\loader\ClassLoader;
use apo\fuzzysearch\ApoFuzzySearch;
use apo\fuzzysearch\Bootstrap;

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Runs only if the plugin is activated
 */
function activate_apo_fuzzy_search($network_wide) {

    awsm_verifyAutoloader( __FILE__ );

    // Add namespace while the plugin is activated
    ClassLoader::instance()->add('apo\fuzzysearch', __DIR__ . '/src');

    // Setup all plugin related stuff like database tables on activation
    $fuzzySearch = new Bootstrap($network_wide);
    $fuzzySearch->up();
}
register_activation_hook( __FILE__, 'activate_apo_fuzzy_search' );

/**
 * Runs only if the plugin is deactivated
 */
function deactivate_apo_fuzzy_search($network_wide) {

    // Remove all plugin related stuff
    $fuzzySearch = new Bootstrap($network_wide);
    $fuzzySearch->down();
}
register_deactivation_hook( __FILE__, 'deactivate_apo_fuzzy_search' );

/**
 * Deactivate the plugin if autoloader is missing. 
 * This is truly important to avoid errors and a blank white page.
 */
awsm_deactivatePluginWhenMissingAutoloader(__FILE__, 'ApoFuzzySearch');

/**
 * Only execute the plugin if it is active and autoloader is available
 */
if( awsm_isPluginActiveAndAutoloaderAvailable(__FILE__) ) {
    ClassLoader::instance()->add('apo\fuzzysearch', __DIR__ . '/src');
    ApoFuzzySearch::instance();   
}

/**
 * Create plugin related tables if a new blog is created
 */
function apo_fuzzy_search_onCreateNewBlog( $blogId, $userId, $domain, $path, $siteId, $meta ) {
    if ( is_plugin_active_for_network( plugin_basename(__FILE__) ) ) {
        $fuzzySearch = new Bootstrap;
        $fuzzySearch->createTablesForNewBlog($blogId);
    }
}
add_action( 'wpmu_new_blog', 'apo_fuzzy_search_onCreateNewBlog', 10, 6 );
