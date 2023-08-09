<?php

GFForms::include_addon_framework();

class GFApovoiceRegistrationInformationAddOn extends GFAddOn {
    protected $_version = GF_APOVOICE_REGISTRATION_INFORMATION_ADDON_VERSION;
    protected $_min_gravityforms_version = '2.2.6';
    protected $_slug = 'apovoiceregistrationinformationaddon';
    protected $_path = 'apovoiceregistrationinformationaddon/apovoiceregistrationinformationaddon.php';
    protected $_full_path = __FILE__;
    protected $_title = 'Gravity Forms apovoice Registration Information Add-On';
    protected $_short_title = 'Registration Information Add-On';

    private static $_instance = null;

    public static function get_instance() {
        if ( self::$_instance == null ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function pre_init() {
        parent::pre_init();

        if ( $this->is_gravityforms_supported() && class_exists( 'GF_Field' ) ) {
            require_once( 'includes/class-apovoice-registration-information-field.php' );
        }
    }
}
