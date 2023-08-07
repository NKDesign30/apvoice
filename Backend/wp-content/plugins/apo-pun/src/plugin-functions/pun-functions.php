<?php
use apo\pun\controllers\AdminViewController;
use apo\pun\roles\PUNManagerRole;

if ( !function_exists( 'apo_pun_add_toplevel_admin_menu' ) ) {
    function apo_pun_add_toplevel_admin_menu() {
        add_menu_page(
            __('PUN Codes', 'apo-pun'),
            __('PUN Codes', 'apo-pun'),
            PUNManagerRole::ACCESS_CAPABILITY,
            'apo-pun-codes',
            [new AdminViewController, 'punCodes'],
            'dashicons-store',
            6
        );
    }
}

add_action( 'admin_menu', 'apo_pun_add_toplevel_admin_menu' );

?>
