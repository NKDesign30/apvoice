<?php 

// ------------ Frontend Settings Page ------------

function apo_frontend_settings_menu() {
    add_options_page( 'Frontend Settings', 'Frontend', 'manage_options', 'apo-frontend', 'apo_frontend_settings_menu_options' );
}

function apo_frontend_settings_menu_options() {
	if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    global $apo_form_locations;
    ?>

	<div class="wrap">
        <h1>Frontend Settings</h1>

        <form method="post" action="options.php">
            <?php settings_fields( 'apo_frontend_settings' ); ?>
            <?php do_settings_sections( 'apo_frontend_settings' ); ?>

            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?= __( 'Maintanance Mode', 'apovoice' ) ?></th>
                    <td>
                        <input
                            type="hidden"
                            name="apo_maintanance"
                            value="0"
                        />
                        <input
                            type="checkbox"
                            name="apo_maintanance"
                            value="1"
                            <?= boolVal(get_option( 'apo_maintanance' )) ? "checked" : "" ; ?>
                        />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?= __( 'Frontend URL', 'apovoice' ) ?></th>
                    <td>
                        <input
                            type="text"
                            name="apo_frontend_url"
                            value="<?= esc_attr( get_option( 'apo_frontend_url' ) ); ?>"
                        />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?= __( 'Frontend SSO URL', 'apovoice' ) ?></th>
                    <td>
                        <input
                                type="text"
                                name="apo_frontend_sso_url"
                                value="<?= esc_attr( get_option( 'apo_frontend_sso_url' ) ); ?>"
                        />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?= __( 'Maximal Expertpoints per Year', 'apovoice' ) ?></th>
                    <td>
                        <input
                            type="text"
                            name="apo_max_expertpoints"
                            value="<?= esc_attr( get_option( 'apo_max_expertpoints' ) ); ?>"
                        />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?= __( 'Voucher Capping Start Date Day/Month', 'apovoice' ) ?></th>
                    <td>
                        <input
                            type="number"
                            min="1"
                            max="31"
                            name="apo_capping_day"
                            value="<?= esc_attr( get_option( 'apo_capping_day' ) ); ?>"
                        />
                        <input
                            type="number"
                            min="1"
                            max="12"
                            name="apo_capping_month"
                            value="<?= esc_attr( get_option( 'apo_capping_month' ) ); ?>"
                        />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?= __( 'Bonago Voucher URL', 'apovoice' ) ?></th>
                    <td>
                        <input
                            type="text"
                            name="apo_bonago_vouchers_url"
                            value="<?= esc_attr( get_option( 'apo_bonago_vouchers_url' ) ); ?>"
                        />
                    </td>
                </tr>
            </table>

            <hr>

            <table class="form-table">
                <tr valign="top">
                    <h2><?= __( 'Form Locations', 'apovoice' ) ?></h2>
                    <p class="description" id="apo-form-locations-description">
                        <?= __( 'Please select a form for the given locations', 'apovoice' ) ?>
                    </p>
                </tr>

                <?php foreach ($apo_form_locations as $form): ?>
                    <tr valign="top">
                        <th scope="row">
                            <?= $form['title']; ?>
                        </th>
                        <td>
                            <select
                                name="<?= $form['key']; ?>"
                                id="<?= $form['key']; ?>"
                                name="<?= $form['key']; ?>"
                            >
                                <option
                                    value=""
                                    disabled
                                    <?= !get_option( $form['key'] ) ? 'selected' : '' ?>
                                >
                                    <?= __( 'Please select a form', 'apovoice' ) ?>
                                </option>
                                <?php foreach (GFAPI::get_forms() as $gForm): ?>
                                    <option
                                        value="<?= $gForm['id'];?>"
                                        <?php selected( $gForm['id'], get_option( $form['key'] ) ); ?>
                                    >
                                        <?= $gForm['title']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <hr>

            <table class="form-table">
                <tr valign="top">
                    <h2><?= __( 'Newsletter Popover', 'apovioce' ) ?></h2>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="frontend-settings-head-code-snippets">
                            <?= __( 'Newsletter Popover', 'apovoice' ) ?>
                        </label>
                    </th>
                    <td>
                        <textarea
                            id="frontend-settings-newsletter-popover"
                            name="apo_newsletter_popover"
                            rows="10"
                            style="width: 100%;"
                        ><?= ! empty( get_option( 'apo_newsletter_popover' ) ) ? get_option( 'apo_newsletter_popover' ) : '' ?></textarea>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="frontend-settings-head-code-snippets">
                            <?= __( 'Newsletter Privacy', 'apovoice' ) ?>
                        </label>
                    </th>
                    <td>
                        <textarea
                            id="frontend-settings-newsletter-popover"
                            name="apo_newsletter_privacy"
                            rows="10"
                            style="width: 100%;"
                        ><?= ! empty( get_option( 'apo_newsletter_privacy' ) ) ? get_option( 'apo_newsletter_privacy' ) : '' ?></textarea>
                    </td>
                </tr>
            </table>

            <hr>

            <table class="form-table">
                <tr valign="top">
                    <h2><?= __( 'Tracking Code Snippets', 'apovioce' ) ?></h2>
                    <p class="description">
                        <?= __( 'You can add as many snippets as you like', 'apovoice' ) ?>
                    </p>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="frontend-settings-head-code-snippets">
                            <?= __( 'Head Code Snippets', 'apovoice' ) ?>
                        </label><br>
                        <small>
                            <?= __( 'These snippets are placed at the top, after the opening head tag', 'apovoice' ) ?>
                        </small>
                    </th>
                    <td>
                        <textarea
                            id="frontend-settings-head-code-snippets"
                            name="apo_head_code_snippets"
                            rows="10"
                            style="width: 100%; font-family: monospace;"
                        ><?= ! empty( get_option( 'apo_head_code_snippets' ) ) ? get_option( 'apo_head_code_snippets' ) : '' ?></textarea>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="frontend-settings-body-code-snippets">
                            <?= __( 'Body Code Snippets', 'apovoice' ) ?>
                        </label><br>
                        <small>
                            <?= __( 'These snippets are placed at the bottom, before the closing body tag', 'apovoice' ) ?>
                        </small>
                    </th>
                    <td>
                        <textarea
                            id="frontend-settings-body-code-snippets"
                            name="apo_body_code_snippets"
                            rows="10"
                            style="width: 100%; font-family: monospace;"
                        ><?= ! empty( get_option( 'apo_body_code_snippets' ) ) ? get_option( 'apo_body_code_snippets' ) : '' ?></textarea>
                    </td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>

    <?php
}

function apo_frontend_settings_register_settings() {
    global $apo_form_locations;

    register_setting( 'apo_frontend_settings', 'apo_maintanance', array(
        'type' => 'string',
        'description' => 'Activating maintanance Mode for apovoice Frontend',
        'show_in_rest' => true,
    ) );

    register_setting( 'apo_frontend_settings', 'apo_frontend_sso_url', array(
        'type' => 'string',
        'description' => 'The URL of the apovoice SSO',
        'show_in_rest' => true,
    ) );

    register_setting( 'apo_frontend_settings', 'apo_frontend_url', array(
        'type' => 'string',
        'description' => 'The URL of the apovoice Frontend',
        'show_in_rest' => true,
    ) );

    register_setting( 'apo_frontend_settings', 'apo_max_expertpoints', array(
        'type' => 'string',
        'description' => 'The maximal Number of Expertpoints that can be exchanges per year',
        'show_in_rest' => false,
    ) );

    register_setting( 'apo_frontend_settings', 'apo_capping_day', array(
        'type' => 'string',
        'description' => 'Day to reset The Yearly allowed Voucher Points',
        'show_in_rest' => false,
    ) );

    register_setting( 'apo_frontend_settings', 'apo_capping_month', array(
        'type' => 'string',
        'description' => 'Month to reset The Yearly allowed Voucher Points',
        'show_in_rest' => false,
    ) );

    register_setting( 'apo_frontend_settings', 'apo_bonago_vouchers_url', array(
        'type' => 'string',
        'description' => 'The URL of Bonago Voucher Redeem URL',
        'show_in_rest' => true,
    ) );

    register_setting( 'apo_frontend_settings', 'apo_newsletter_popover', array(
        'type' => 'string',
        'description' => 'Text for Newsletter Popover',
        'show_in_rest' => true,
    ) );

    register_setting( 'apo_frontend_settings', 'apo_newsletter_privacy', array(
        'type' => 'string',
        'description' => 'Text for Newsletter Popover Privacyterms',
        'show_in_rest' => true,
    ) );

    register_setting( 'apo_frontend_settings', 'apo_head_code_snippets', array(
        'type' => 'string',
        'description' => 'The code snippets for the head section',
        'show_in_rest' => true,
    ) );

    register_setting( 'apo_frontend_settings', 'apo_body_code_snippets', array(
        'type' => 'string',
        'description' => 'The code snippets for the body section',
        'show_in_rest' => true,
    ) );

    foreach ($apo_form_locations as $form) {
        register_setting( 'apo_frontend_settings', $form['key'], array(
            'type' => 'string',
            'description' => 'The Gravity-Form-ID of the register form',
            'show_in_rest' => true,
        ) );
    }
}

add_action( 'admin_menu', 'apo_frontend_settings_menu' );
add_action( 'admin_init', 'apo_frontend_settings_register_settings' );
