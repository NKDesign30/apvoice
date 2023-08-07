<?php
/*
Plugin Name: ApoMigration
Plugin URI: https://www.awsm.rocks
Description: Migrate the DE and AT Platform
Version: 1.0.0
Author: AWESOME! Software GmbH
Author URI:  https://www.awsm.rocks
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: apo_migration
 */


/**
 * Dont declare a namespace in this file
 * this will come's to conflicts with the wordpress `register_activation_hook` 
 */
use awsm\wp\loader\ClassLoader;
use apo\migration\ApoMigration;
use apo\migration\Bootstrap;

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Runs only if the plugin is activated
 */
function activate_apo_migration($network_wide) {

    awsm_verifyAutoloader( __FILE__ );

    // Add namespace while the plugin is activated
    ClassLoader::instance()->add('apo\migration', __DIR__ . '/src');

    // Setup all plugin related stuff like database tables on activation
    $apo_migration = new Bootstrap($network_wide);
    $apo_migration->up();
}
register_activation_hook( __FILE__, 'activate_apo_migration' );

/**
 * Runs only if the plugin is deactivated
 */
function deactivate_apo_migration($network_wide) {

    // Remove all plugin related stuff
    $apo_migration = new Bootstrap($network_wide);
    $apo_migration->down();
}
register_deactivation_hook( __FILE__, 'deactivate_apo_migration' );

/**
 * Deactivate the plugin if autoloader is missing. 
 * This is truly important to avoid errors and a blank white page.
 */
awsm_deactivatePluginWhenMissingAutoloader(__FILE__, 'ApoMigration');

/**
 * Only execute the plugin if it is active and autoloader is available
 */
if( awsm_isPluginActiveAndAutoloaderAvailable(__FILE__) ) {
    ClassLoader::instance()->add('apo\migration', __DIR__ . '/src');
    ApoMigration::instance();   
}
