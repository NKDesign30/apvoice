<?php 

// ------------ Gravity Forms Helpers ------------

function apo_gform_get_field_by_class($form, $class) {
    $current_page = rgpost( 'gform_source_page_number_' . $form['id'] ) ? rgpost( 'gform_source_page_number_' . $form['id'] ) : 1;

    $field = array_filter( $form['fields'], function ( $f ) use ( $form, $class, $current_page ) {
        $is_hidden = RGFormsModel::is_field_hidden( $form, $f, array() );

        if ($is_hidden) {
            return false;
        }

        $field_page = $f->pageNumber;

        if ( $field_page != $current_page) {
            return false;
        }

        return strpos( $f->cssClass, $class ) !== false;
    } );

    return array_values( $field )[0];
}
