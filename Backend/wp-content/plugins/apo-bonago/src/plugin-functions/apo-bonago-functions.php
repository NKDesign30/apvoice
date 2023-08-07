<?php

use apo\bonago\controllers\AdminViewController;
use apo\bonago\roles\BonagoVoucherManagerRole;

if ( !function_exists( 'apo_bonago_add_toplevel_admin_menu' ) ) {
    function apo_bonago_add_toplevel_admin_menu() {
        add_menu_page(
            __('Bonago Vouchers', 'apovoice-bonago'),
            __('Bonago Vouchers', 'apovoice-bonago'),
            BonagoVoucherManagerRole::ACCESS_CAPABILITY,
            'apo-bonago',
            [new AdminViewController, 'bonagoVouchers'],
            'dashicons-tickets',
            7
        );
    }
}

add_action( 'admin_menu', 'apo_bonago_add_toplevel_admin_menu' );

if ( !function_exists( 'apo_bonago_is_current_link' ) ) {
    function apo_bonago_is_current_link($link) {
        $filter = $_GET['filter'] ?? 'all';
        return $link === $filter ? 'current' : null;
    }
}

?>
