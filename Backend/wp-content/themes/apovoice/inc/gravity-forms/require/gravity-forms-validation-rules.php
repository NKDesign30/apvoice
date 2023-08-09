<?php

// ------------ Gravity Forms Custom Validation Rules ------------

function apo_is_valid_expert_code( $value ) {
    global $wpdb;
    
    $sql = $wpdb->prepare( "
        SELECT
            COUNT(`expert_code`)
        FROM
            `{$wpdb->prefix}expert_codes`
        WHERE
            BINARY `expert_code` = %s AND
            (
                `usages` IS NULL OR
                `used` < `usages`
            )
    ", $value );

    return (bool) (int) $wpdb->get_var( $sql );
}

function apo_is_invitation_expert_code( $value ) {
    global $wpdb;

    $sql = $wpdb->prepare( '
        SELECT
            `user_id`
        FROM
            `'.$wpdb->base_prefix.'usermeta`
        WHERE
            `meta_value` LIKE CONCAT("%\"", %s, "\"%") AND
            `meta_key` = "invitation_codes" 
    ', $value );

    
    $user_id = $wpdb->get_var( $sql );

    if($user_id){
        return get_userdata($user_id);
    }
    return false;
}

function apo_is_reusable_expert_code( $value ) {
    global $wpdb;

    $sql = $wpdb->prepare( "
        SELECT
            COUNT(`expert_code`)
        FROM
            `{$wpdb->prefix}expert_codes`
        WHERE
            BINARY `expert_code` = %s AND
            `usages` IS NULL 
    ", $value );

    return (bool) (int) $wpdb->get_var( $sql );
}

function apo_is_valid_pg_customer_id( $value ) {
    global $wpdb;

    $sql = $wpdb->prepare( "
        SELECT
            COUNT(`pg_customer_id`)
        FROM
            `{$wpdb->prefix}apovoice_pgci`
        WHERE
            BINARY `pg_customer_id` = %s
    ", $value );

    return (bool) (int) $wpdb->get_var( $sql );
}

function apo_is_valid_captcha( $value ) {
    if(empty($value)) {
        error_log('captcha not clicked');
        return false;
    }
    $secret = get_option( 'rg_gforms_captcha_private_key' );
    // $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$value);
    // $responseData = json_decode($verifyResponse);

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => [
            'secret' => $secret,
            'response' => $value,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ],
        CURLOPT_RETURNTRANSFER => true
    ]);

    $output = curl_exec($ch);
    curl_close($ch);

    error_log($output);
    $responseData = json_decode($output);

    return (boolean)$responseData->success;
}


function apo_is_valid_pharmacy_unique_number( $value ) {
    global $wpdb;

    $sql = $wpdb->prepare( "
        SELECT
            COUNT(`id`)
        FROM
            `{$wpdb->prefix}apovoice_pharmacies`
        WHERE
            `pharmacy_unique_number` = %s
    ", $value );

    return (bool) (int) $wpdb->get_var( $sql );
}


function apo_redeem_expert_code( $user_id, $expert_code ) {
    global $wpdb;

    $sql = $wpdb->prepare( "
        UPDATE
            `{$wpdb->prefix}expert_codes`
        SET
            `used` = `used` + 1
        WHERE
            `expert_code` = %s
    ", $expert_code );

    $wpdb->query( $sql );

    update_user_meta( $user_id, 'registered_expert_code', $expert_code );
}


function apo_can_user_reset_password( $user_id ) {
    $is_allowed = apply_filters( 'allow_password_reset', true, $user_id );

    return !is_wp_error( $is_allowed ) && (bool) $is_allowed;
}

function apo_is_valid_password( $password ) {
    return (bool) preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d\W_][^\s]{8,}$/', $password ) !== false;
}


function apo_gform_validate_expert_code( $validation_result ) {
    $form = $validation_result['form'];
    $current_page = rgpost( 'gform_source_page_number_' . $form['id'] ) ? rgpost( 'gform_source_page_number_' . $form['id'] ) : 1;

    foreach( $form['fields'] as &$field ) {
        // Hidden fields should not be validated
        $is_hidden = RGFormsModel::is_field_hidden( $form, $field, array() );

        if ($is_hidden) {
            continue;
        }

        // If the field is not on the current page, skip validation
        $field_page = $field->pageNumber;

        if ( $field_page != $current_page) {
            continue;
        }

        // Look for a field with the CSS Class "validate-expert-code"
        // TODO: Find a better approach to this, since this is really cumbersome and briddle :(
        if ( strpos( $field->cssClass, 'validate-expert-code' ) === false ) {
            continue;
        }

        $field_value = rgpost( "input_{$field['id']}" );
        $is_valid = apo_is_valid_expert_code( $field_value );

        if (! $is_valid) {
            $validation_result['is_valid'] = false;
            $field->failed_validation = true;
            $field->validation_message = __( 'Expert Code not found', 'apovoice' );
            $validation_result['form'] = $form;
        }

    }

    return $validation_result;
}

function apo_gform_validate_expert_only_pharmacies( $validation_result ) {
    $form = $validation_result['form'];
    $current_page = rgpost( 'gform_source_page_number_' . $form['id'] ) ? rgpost( 'gform_source_page_number_' . $form['id'] ) : 1;
    $locale = get_locale();
    $ex_code = null;
    $field_value = null;
    $field_set = false;
    $_field = null;

    if($locale != "de_DE" && $locale != "de_AT")
        return $validation_result;

    foreach( $form['fields'] as &$field ) {
        // Hidden fields should not be validated
        $is_hidden = RGFormsModel::is_field_hidden( $form, $field, array() );

        if ( strpos( $field->cssClass, 'validate-expert-code' ) !== false ) {
            $ex_code = $field;
        }

        if ($is_hidden) {
            continue;
        }

        // If the field is not on the current page, skip validation
        $field_page = $field->pageNumber;

        if ( $field_page != $current_page) {
            continue;
        }

        // Look for a field with the CSS Class "validate-captcha"
        // TODO: Find a better approach to this, since this is really cumbersome and briddle :(
        if ( strpos( $field->cssClass, 'validate-expert_only_pharmacies' ) === false ) {
            continue;
        }
        $field_value = json_decode(rgpost( "input_{$field['id']}" ));
        $field_set = true;
        $_field = $field;
    }
    $ex_code_value = rgpost( "input_{$ex_code['id']}" );
    $is_valid = !$field_set || (trim($ex_code_value) == "" || (is_array($field_value) && count($field_value) > 0));

    if (! $is_valid) {
        $validation_result['is_valid'] = false;
        $_field->failed_validation = true;
        $_field->validation_message = trim($_field->errorMessage) != "" ? $_field->errorMessage : __( 'Please enter a Pharmacie Address', 'apovoice' );
        $validation_result['form'] = $form;
    }

    return $validation_result;
}

function apo_gform_validate_recaptcha( $validation_result ) {
    $form = $validation_result['form'];
    $current_page = rgpost( 'gform_source_page_number_' . $form['id'] ) ? rgpost( 'gform_source_page_number_' . $form['id'] ) : 1;

    foreach( $form['fields'] as &$field ) {
        // Hidden fields should not be validated
        $is_hidden = RGFormsModel::is_field_hidden( $form, $field, array() );

        if ($is_hidden) {
            continue;
        }

        // If the field is not on the current page, skip validation
        $field_page = $field->pageNumber;

        if ( $field_page != $current_page) {
            continue;
        }

        // Look for a field with the CSS Class "validate-captcha"
        // TODO: Find a better approach to this, since this is really cumbersome and briddle :(
        if ( strpos( $field->cssClass, 'validate-captcha' ) === false ) {
            continue;
        }
        $field->failed_validation = false;
        $field->validation_message = "";

        $field_value = rgpost( "input_{$field['id']}" );
        $is_valid = apo_is_valid_captcha( $field_value );
        error_log('valid? '.$is_valid);

        if (! $is_valid) {
            $validation_result['is_valid'] = false;
            $field->failed_validation = true;
            $field->validation_message = __( 'You are a robot', 'apovoice' );
            $validation_result['form'] = $form;
        }
    }

    return $validation_result;
}

function apo_gform_validate_password( $validation_result ) {
    $form = $validation_result['form'];
    $current_page = rgpost( 'gform_source_page_number_' . $form['id'] ) ? rgpost( 'gform_source_page_number_' . $form['id'] ) : 1;

    foreach( $form['fields'] as &$field ) {
        // Hidden fields should not be validated
        $is_hidden = RGFormsModel::is_field_hidden( $form, $field, array() );

        if ($is_hidden) {
            continue;
        }

        // If the field is not on the current page, skip validation
        $field_page = $field->pageNumber;

        if ( $field_page != $current_page) {
            continue;
        }

        // Look for a field with the CSS Class "validate-password"
        // TODO: Find a better approach to this, since this is really cumbersome and briddle :(
        if ( strpos( $field->cssClass, 'validate-password' ) === false ) {
            continue;
        }

        $field_value = rgpost( "input_{$field['id']}" );

        $is_valid = apo_is_valid_password( $field_value );

        if (! $is_valid) {
            $validation_result['is_valid'] = false;
            $field->failed_validation = true;
            $field->validation_message = __( 'Weak Password. Password must contain at least 8 characters including at least one number, uppercase and lowercase character.', 'apovoice' );
            $validation_result['form'] = $form;
        }
    }

    return $validation_result;
}


function apo_gform_validate_pharmacy_unique_number( $validation_result ) {
    $form = $validation_result['form'];
    $current_page = rgpost( 'gform_source_page_number_' . $form['id'] ) ? rgpost( 'gform_source_page_number_' . $form['id'] ) : 1;

    foreach( $form['fields'] as &$field ) {
        // Hidden fields should not be validated
        $is_hidden = RGFormsModel::is_field_hidden( $form, $field, array() );

        if ($is_hidden) {
            continue;
        }

        // If the field is not on the current page, skip validation
        $field_page = $field->pageNumber;

        if ( $field_page != $current_page) {
            continue;
        }

        // Look for a field with the CSS Class "validate-pharmacy-unique-number"
        // TODO: Find a better approach to this, since this is really cumbersome and briddle :(
        if ( strpos( $field->cssClass, 'validate-pharmacy-unique-number' ) === false ) {
            continue;
        }

        $field_value = rgpost( "input_{$field['id']}" );
        $is_valid = apo_is_valid_pharmacy_unique_number( $field_value );

        if (! $is_valid) {
            $validation_result['is_valid'] = false;
            $field->failed_validation = true;
            $field->validation_message = __( 'Incorrect Pharmacy Unique Number', 'apovoice' );
            $validation_result['form'] = $form;
        }
    }

    return $validation_result;
}


function apo_gform_validate_user_email( $validation_result ) {
    $form = $validation_result['form'];
    $current_page = rgpost( 'gform_source_page_number_' . $form['id'] ) ? rgpost( 'gform_source_page_number_' . $form['id'] ) : 1;

    foreach( $form['fields'] as &$field ) {
        // Hidden fields should not be validated
        $is_hidden = RGFormsModel::is_field_hidden( $form, $field, array() );

        if ($is_hidden) {
            continue;
        }

        // If the field is not on the current page, skip validation
        $field_page = $field->pageNumber;

        if ( $field_page != $current_page) {
            continue;
        }

        // Look for a field with the CSS Class "validate-user-email"
        // TODO: Find a better approach to this, since this is really cumbersome and briddle :(
        if ( strpos( $field->cssClass, 'validate-user-email' ) === false ) {
            continue;
        }

        $field_value = rgpost( "input_{$field['id']}" );
        $user_data = get_user_by( 'email', trim( $field_value ) );

        if ( empty( $user_data ) ) {
            $validation_result['is_valid'] = false;
            $field->failed_validation = true;
            $field->validation_message = __( 'This email does not exist', 'apovoice' );
            $validation_result['form'] = $form;
        }

        $is_allowed = apo_can_user_reset_password( $user_data->ID );

        if ( !$is_allowed ) {
            $validation_result['is_valid'] = false;
            $field->failed_validation = true;
            $field->validation_message = __('You\'re not allowed to change your password right now', 'apovoice' );
            $validation_result['form'] = $form;
        }
    }

    return $validation_result;
}


function apo_gform_validate_password_reset_key( $validation_result ) {
    global $wpdb;

    $form = $validation_result['form'];
    $current_page = rgpost( 'gform_source_page_number_' . $form['id'] ) ? rgpost( 'gform_source_page_number_' . $form['id'] ) : 1;

    foreach( $form['fields'] as &$field ) {
        // Hidden fields should not be validated
        $is_hidden = RGFormsModel::is_field_hidden( $form, $field, array() );

        if ($is_hidden) {
            continue;
        }

        // If the field is not on the current page, skip validation
        $field_page = $field->pageNumber;

        if ( $field_page != $current_page) {
            continue;
        }

        // Look for the hidden field
        if ( $field->type !== 'hidden' ) {
            continue;
        }

        $field_value = rgpost( "input_{$field['id']}" );

        $query = $wpdb->prepare( "
            SELECT
                `id`
            FROM
                `{$wpdb->users}`
            WHERE
                `user_activation_key` = %s
        ", array( trim( $field_value ) ) );

        $user_id = $wpdb->get_var( $query );

        if ( empty( $user_id ) ) {
            $validation_result['is_valid'] = false;
            $field->failed_validation = true;
            $field->validation_message = __( 'The password reset key is invalid. Please make sure you copied the whole URL to your browsers address bar', 'apovoice' );
            $validation_result['form'] = $form;
        } else {
            $user_data = get_user_by( 'id', $user_id );

            $key_parts = explode( ':', trim( $field_value ) );

            list( $timestamp, $hash ) = $key_parts;

            if ( ($timestamp + 3600) <= time() ) {
                $validation_result['is_valid'] = false;
                $field->failed_validation = true;
                $field->validation_message = __( 'Your password reset key is expired. Please go to the forgot password page and try again.', 'apovoice' );
                $validation_result['form'] = $form;
            }
        }
    }

    return $validation_result;
}


function apo_update_associated_pharmacies( $user_id ) {
    global $wpdb;

    $pharmacy_unique_number = get_user_meta( $user_id, 'associated_pharmacies', true );
    $additional_pharmacy_unique_numbers = get_user_meta( $user_id, 'associated_pharmacies_extra', true );

    $pharmacy_unique_numbers = array_filter(
        array_merge( array( $pharmacy_unique_number ), explode( ',', $additional_pharmacy_unique_numbers ) )
    );

    $placeholders = array_fill( 0, count( $pharmacy_unique_numbers ), '%s' );

    $sql = $wpdb->prepare( "
        SELECT
            `id`
        FROM
            `{$wpdb->prefix}apovoice_pharmacies`
        WHERE
            `pharmacy_unique_number` IN (" . implode( ', ', $placeholders ) . ")
    ", $pharmacy_unique_numbers );

    $pharmacy_ids = $wpdb->get_col( $sql );

    $values = array_map( function ( $pharmacy_id ) use ( $wpdb, $user_id ) {
        return $wpdb->prepare( '(%d, %d)', array( $pharmacy_id, $user_id ) );
    }, $pharmacy_ids );

    $sql = "
        INSERT INTO
            `{$wpdb->prefix}apovoice_pharmacy_user`
            (
                `pharmacy_id`,
                `user_id`
            )
        VALUES
    " . implode( ', ', $values );

    $wpdb->query( $sql );

    delete_user_meta( $user_id, 'associated_pharmacies' );
    delete_user_meta( $user_id, 'associated_pharmacies_extra' );

    update_user_meta( $user_id, 'registered_pharmacy_unique_number', $pharmacy_ids[0] );
}
