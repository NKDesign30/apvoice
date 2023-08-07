<?php 

// ------------ Gravity Forms Settings ------------

function apo_add_dynamic_gform_register_settings() {
    $form_id = get_option( 'apo_register_form' );

    // generate dynamic username during the registration process
    add_filter( 'gform_username_' . $form_id, 'apo_user_registration_feed_dynamic_username', 10, 4 );
    // add_filter( 'gform_user_registration_username_' . $form_id, 'apo_user_registration_feed_dynamic_username', 10, 4 );

    // validation rules
    add_filter( 'gform_validation_' . $form_id, 'apo_gform_validate_expert_code' );
    add_filter( 'gform_validation_' . $form_id, 'apo_gform_validate_pharmacy_unique_number' );
    add_filter( 'gform_validation_' . $form_id, 'apo_gform_validate_password' );
    add_filter( 'gform_validation_' . $form_id, 'apo_gform_validate_expert_only_pharmacies' );

    //add_filter( 'gform_validation_' . $form_id, 'apo_gform_validate_recaptcha' );
}


function apo_add_dynamic_gform_password_forgotten_settings() {
    $form_id = get_option( 'apo_password_forgotten_form' );

    // validation rules
    add_filter( 'gform_validation_' . $form_id, 'apo_gform_validate_user_email' );

    // pre submissions
    add_action( 'gform_pre_submission_' . $form_id, 'apo_gform_reset_password' );
}


function apo_add_dynamic_gform_reset_password_settings() {
    $form_id = get_option( 'apo_reset_password_form' );

    // validation rules
    add_filter( 'gform_validation_' . $form_id, 'apo_gform_validate_password_reset_key' );
    add_filter( 'gform_validation_' . $form_id, 'apo_gform_validate_password' );

    // pre submissions
    add_action( 'gform_pre_submission_' . $form_id, 'apo_gform_change_password' );
}


function apo_initialize_registered_user_meta( $user_id ) {
    add_user_meta( $user_id, 'profile_picture', [], true );
    add_user_meta( $user_id, 'title', '', true );
    add_user_meta( $user_id, 'form_of_address', '', true );
    add_user_meta( $user_id, 'working_since', '', true );
    add_user_meta( $user_id, 'age', '', true );
    add_user_meta( $user_id, 'tasks', [], true );
    add_user_meta( $user_id, 'priorities', [], true );
    add_user_meta( $user_id, 'registered_pharmacy_unique_number', '', true );
}


function apo_add_dynamic_gform_settings() {
    apo_add_dynamic_gform_register_settings();
    apo_add_dynamic_gform_password_forgotten_settings();
    apo_add_dynamic_gform_reset_password_settings();
}
add_action( 'after_setup_theme', 'apo_add_dynamic_gform_settings' );


function apo_gform_user_registered( $user_id, $feed, $entry, $user_pass ) {
    $expert_code = get_user_meta( $user_id, 'register_expert_code', true );

    apo_redeem_expert_code( $user_id, $expert_code );
    apo_update_associated_pharmacies( $user_id );
    apo_initialize_registered_user_meta( $user_id );
    update_user_meta($user_id, 'primary_blog', get_current_blog_id(), true);
    if(apo_is_reusable_expert_code($expert_code))
        add_user_meta( $user_id, 'is_pending', '1', true );
    else
        add_user_meta( $user_id, 'is_pending', '0', true );

    //send mail if invitationcode
    if($user = apo_is_invitation_expert_code($expert_code)){
        global $wpdb;
        $wpdb->query("INSERT INTO `{$wpdb->prefix}expert_points` (`user_id`, `points_earned`, `related_type`, `related_id`) VALUES ({$user->ID}, 30, 'invitation-{$expert_code}', -1)");
        wp_mail( 
            $user->data->user_email, 
            __("Your Invitationcode has been used.", 'rxts'), 
            __("Your Invitationcode has been used and you have received 30 Expertpoints.", 'rxts')
        );
    }
}
add_action( 'gform_user_registered', 'apo_gform_user_registered', 10, 4 );


function apo_gform_add_custom_registration_url_tag( $text, $form, $entry, $url_encode, $esc_html, $nl2br, $format ) {
    if ( empty( $entry ) || empty( $form ) ) {
        return $text;
    }

    $custom_activation_url_merge_tag = '{custom_activation_url}';
    if ( strpos( $text, $custom_activation_url_merge_tag ) !== false ) {
        $key = gform_get_meta( $entry['id'], 'activation_key' );
        $frontend_url = get_option( 'apo_frontend_url' );

        $url = empty( $key ) || empty( $frontend_url ) ? '' : "{$frontend_url}/activation/{$key}";

        $text = str_replace( $custom_activation_url_merge_tag, $url, $text );
    }

    return $text;
}
add_filter( 'gform_replace_merge_tags', 'apo_gform_add_custom_registration_url_tag', 10, 7 );


function apo_gform_add_custom_password_reset_url_tag( $text, $form, $entry, $url_encode, $esc_html, $nl2br, $format ) {
    global $wpdb;

    if ( empty( $entry ) || empty( $form ) ) {
        return $text;
    }

    $field = apo_gform_get_field_by_class( $form, 'validate-user-email' );

    $field_value = rgpost( "input_{$field['id']}" );
    $user_data = get_user_by( 'email', $field_value );

    $query = $wpdb->prepare( "
        SELECT
            `user_activation_key`
        FROM
            `{$wpdb->users}`
        WHERE
            `id` = %d
    " , array( $user_data->ID ) );

    $user_activation_key = $wpdb->get_var( $query );

    $custom_password_reset_url_merge_tag = '{custom_password_reset_url}';

    if ( strpos( $text, $custom_password_reset_url_merge_tag ) !== false ) {
        $frontend_url = get_option( 'apo_frontend_url' );

        if (empty( $user_activation_key ) || empty( $frontend_url )) {
            $url = '';
        } else {
            $encoded_user_activation_key = base64_encode( $user_activation_key );
            $url = "{$frontend_url}/reset/{$encoded_user_activation_key}";
        }

        $text = str_replace( $custom_password_reset_url_merge_tag, $url, $text );
    }

    return $text;
}
add_filter( 'gform_replace_merge_tags', 'apo_gform_add_custom_password_reset_url_tag', 10, 7 );


function apo_gform_reset_password( $form ) {
    global $wpdb, $wp_hasher;

    $field = apo_gform_get_field_by_class( $form, 'validate-user-email' );

    $field_value = rgpost( "input_{$field['id']}" );
    $user_data = get_user_by( 'email', $field_value );

    $user_login = $user_data->user_login;
    $user_email = $user_data->user_email;

    $key = wp_generate_password( 20, false );

    if ( empty( $wp_hasher ) ) {
        require_once ABSPATH . WPINC . '/class-phpass.php';
        $wp_hasher = new PasswordHash( 8, true );
    }

    $hashed_key = time() . ':' . $wp_hasher->HashPassword( $key );

    $wpdb->update(
        $wpdb->users,
        array( 'user_activation_key' => $hashed_key ),
        array( 'user_login' => $user_login )
    );
}


function apo_gform_change_password( $form ) {
    global $wpdb;

    $password_field = array_filter( $form['fields'], function ( $field ) {
        return $field->type === 'password';
    } );

    $user_activation_key_field = array_filter( $form['fields'], function ( $field ) {
        return $field->type === 'hidden';
    } );

    $password_field = array_values( $password_field )[0];
    $user_activation_key_field = array_values( $user_activation_key_field )[0];

    $new_password = rgpost( "input_{$password_field['id']}" );
    $user_activation_key = rgpost( "input_{$user_activation_key_field['id']}" );

    $query = $wpdb->prepare( "
        SELECT
            `id`
        FROM
            `{$wpdb->users}`
        WHERE
            `user_activation_key` = %s
    ", array( trim( $user_activation_key ) ) );

    $user_id = $wpdb->get_var( $query );

    reset_password( get_user_by('ID', $user_id), $new_password );

    $query = $wpdb->prepare( "
        UPDATE
            `{$wpdb->users}`
        SET
            `user_activation_key` = ''
        WHERE
            `id` = %d
    ", array( $user_id ) );
}


// ------------ Gravity Forms Registration Feed Settings ------------

function apo_user_registration_feed_dynamic_username( $username, $feed, $form, $entry ) {

    $initials = strtolower( rgar( $entry, '1' )[0] . rgar( $entry, '2' )[0] );
    $strippedEmail = preg_replace("/[^A-Za-z0-9]/", '', strtolower( explode( '@', rgar( $entry, '6' ) )[0] ));

    $dynamicUsername = $initials . $strippedEmail;
 
    $i = 2;
    if ( empty( $dynamicUsername ) ) {
        return $username;
    }

    if ( ! function_exists( 'username_exists' ) ) {
        require_once( ABSPATH . WPINC . '/registration.php' );
    }

    if ( username_exists( $dynamicUsername ) ) {
        
        while ( username_exists( $dynamicUsername . $i ) ) {
            $i++;
        }
        $dynamicUsername = $dynamicUsername . $i;

    };

    return $dynamicUsername;
}

function apo_after_user_activate( $user_id, $user_data, $signup_meta ) {
    update_user_meta($user_id, 'primary_blog', get_current_blog_id(), true);
}

add_action( 'gform_activate_user', 'apo_after_user_activate', 10, 3 );

function apo_gform_add_custom_email_confirm_url_tag( $text, $form, $entry, $url_encode, $esc_html, $nl2br, $format ) {
    global $wpdb;

    if ( empty( $entry ) || empty( $form ) ) {
        return $text;
    }

    $custom_email_confirm_url_merge_tag = '{custom_email_confirm_url}';

    if ( strpos( $text, $custom_email_confirm_url_merge_tag ) !== false ) {

        $field = apo_gform_get_field_by_class( $form, 'validate-user-email' );

        $user_data = get_user_by( 'email', $entry['2'] );

        $query = $wpdb->prepare( "
            SELECT
                `user_activation_key`
            FROM
                `{$wpdb->users}`
            WHERE
                `id` = %d
        " , array( $user_data->ID ) );

        $user_activation_key = $wpdb->get_var( $query );

        $frontend_url = get_option( 'apo_frontend_url' );

        if (empty( $user_activation_key ) || empty( $frontend_url )) {
            $url = "{$frontend_url}/confirmemail/";
        } else {
            $encoded_user_activation_key = base64_encode( $user_activation_key );
            $url = "{$frontend_url}/confirmemail/{$encoded_user_activation_key}";
        }

        $text = str_replace( $custom_email_confirm_url_merge_tag, $url, $text );
    }

    return $text;
}
add_filter( 'gform_replace_merge_tags', 'apo_gform_add_custom_email_confirm_url_tag', 10, 7 );