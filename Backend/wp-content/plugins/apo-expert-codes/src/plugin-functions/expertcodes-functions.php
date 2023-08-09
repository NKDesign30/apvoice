<?php

use apo\expertcodes\roles\ExpertCodeManagerRole;

if ( !function_exists( 'apo_expertcodes_create_expert_codes_frontpage' ) ) {
    function apo_expertcodes_create_expert_codes_frontpage() {
        include APO_EXPERT_CODES_VIEWS_DIR . 'admin.php';
    }
}

if ( !function_exists( 'apo_expertcodes_add_toplevel_admin_menu' ) ) {
    function apo_expertcodes_add_toplevel_admin_menu() {
        add_menu_page(
            __('Expert Codes', 'apovoice-expert-codes'),
            __('Expert Codes', 'apovoice-expert-codes'),
            ExpertCodeManagerRole::ACCESS_CAPABILITY,
            'apo-expert-codes',
            'apo_expertcodes_create_expert_codes_frontpage',
            'dashicons-id-alt',
            6
        );
    }
}

add_action( 'admin_menu', 'apo_expertcodes_add_toplevel_admin_menu' );

?>
