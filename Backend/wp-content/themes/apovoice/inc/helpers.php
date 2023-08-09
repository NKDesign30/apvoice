<?php

// ------------ Helpers ------------

function array_map_keys( $values, $callback ) {
    $result = [];

    foreach ($values as $key => $value) {
        $result[$key] = $callback( $value, $key );
    }

    return $result;
}


function array_every( $values, $callback ) {
    foreach ( $values as $key => $value ) {
        if ( ! $callback( $value, $key ) ) {
            return false;
        }
    }

    return true;
}


function array_some( $values, $callback ) {
    foreach ( $values as $key => $value ) {
        if ( $callback( $value, $key ) ) {
            return true;
        }
    }

    return false;
}


function dd( ...$args ) {
    $args = array_filter( $args );

    array_map( function ( $arg ) {
        print( '<pre>' . print_r( $arg, true ) . '</pre>' );
    }, $args );

    die();
}


function apo_user_upload_dir( $append = null ) {
    $path = realpath( wp_upload_dir()['basedir'] . '/../user-uploads' );

    return is_null( $append ) ? $path : "{$path}/${append}";
}


function pre( $value ) {
    print( '<pre>' . print_r( $value, true ) . '</pre>' );
}

function array_pluck( array &$array, $key) {
    if ( array_key_exists($key, $array) ) {
        $value = $array[$key];
        unset($array[$key]);

        return $value;
    }

    return null;
}


function apo_get_job_roles(){
    $forms = GFAPI::get_forms();
    foreach($forms as $form){
        if(strpos($form['cssClass'], 'apo_registration') !== false){
            foreach($form['fields'] as $temp){
                if(strpos($temp->cssClass, 'apo_job_role') !== false)
                    $field = $temp;
            }
        }
    }
    return $field->choices;
}