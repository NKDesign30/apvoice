<?php

use apo\migration\controllers\AdminViewController;

if ( !function_exists( 'apo_migration_add_toplevel_admin_menu' ) ) {
    function apo_migration_add_toplevel_admin_menu() {
        add_menu_page(
            'Migration',
            'Migration',
            '',
            'application-migration',
            [new AdminViewController, 'migration'],
            'dashicons-networking',
            6
        );
    }
}
add_action( 'admin_menu', 'apo_migration_add_toplevel_admin_menu' );

if ( !function_exists( 'apo_can_run_migration' ) ) {
    function apo_can_run_migration($migrationStatus, $dependsOn) {
        if ( is_null($dependsOn) ) return true;
    
        if (is_string($dependsOn) ) {
            $dependsOn = [$dependsOn];
        }
    
        return sizeof(array_filter($dependsOn, function($status) use ($migrationStatus) {
            return (bool) $migrationStatus->$status;
        })) === sizeof($dependsOn);
    }
}

if ( !function_exists( 'apo_has_run_migration' ) ) {
    function apo_has_run_migration($migrationStatus, $status) {
        return (bool) $migrationStatus->$status;
    }
}
