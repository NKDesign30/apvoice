<?php
use apo\reporting\controllers\AdminViewController;

if ( !function_exists( 'apo_reporting_add_admin_menua' ) ) {
    function apo_reporting_add_admin_menua() {

        add_menu_page(
            __('Reporting', 'apo_reporting'),
            __('Reporting', 'apo_reporting'),
            'read_reporting',
            'apo-reporting',
            [new AdminViewController, 'reporting'],
            'dashicons-analytics',
            9
        );

        add_submenu_page(
            'apo-reporting',
            'Settings',
            'Settings',
            'reinsert_reporting_statistics',
            'settings',
            [new AdminViewController, 'settings'],
        );

    }
}

add_action( 'admin_menu', 'apo_reporting_add_admin_menua' );
