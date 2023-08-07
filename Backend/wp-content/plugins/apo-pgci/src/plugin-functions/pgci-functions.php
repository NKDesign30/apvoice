<?php
use apo\pgci\controllers\AdminViewController;
use apo\pgci\roles\PGCIManagerRole;

if ( !function_exists( 'apo_pgci_add_toplevel_admin_menu' ) ) {
    function apo_pgci_add_toplevel_admin_menu() {
        add_menu_page(
            __('P&G Customer IDs', 'apo-pgci'),
            __('P&G Customer IDs', 'apo-pgci'),
            PGCIManagerRole::ACCESS_CAPABILITY,
            'apo-pgci-codes',
            [new AdminViewController, 'pgciCodes'],
            'dashicons-store',
            6
        );
    }
}

add_action( 'admin_menu', 'apo_pgci_add_toplevel_admin_menu' );

?>
