<?php

class Apovoice_Registration_Information_Field extends GF_Field {
    public $type = 'apovoice_registration_information';

    public function get_form_editor_field_title() {
        return esc_attr__( 'apovoice Registration Information', 'apovoiceregistrationpinformation' );
    }

    public function get_form_editor_button() {
        return array(
            'group' => 'advanced_fields',
            'text'  => $this->get_form_editor_field_title(),
        );
    }

	public function get_form_editor_field_settings() {
		return array(
            'label_placement_setting',
            'description_setting',
		);
    }

	public function get_field_input( $form, $value = '', $entry = null ) {
		return '';
	}
}

GF_Fields::register( new Apovoice_Registration_Information_Field() );
