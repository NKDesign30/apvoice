<?php

GFForms::include_addon_framework();

class GFApovoiceRegistrationPharmacySummaryAddOn extends GFAddOn {
    protected $_version = GF_APOVOICE_REGISTRATION_PHARMACY_SUMMARY_ADDON_VERSION;
    protected $_min_gravityforms_version = '2.2.6';
    protected $_slug = 'apovoiceregistrationpharmacysummaryaddon';
    protected $_path = 'apovoiceregistrationpharmacysummaryaddon/apovoiceregistrationpharmacysummaryaddon.php';
    protected $_full_path = __FILE__;
    protected $_title = 'Gravity Forms apovoice Registration Pharmacy Summary Add-On';
    protected $_short_title = 'Registration Pharmacy Summary Add-On';

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
            require_once( 'includes/class-apovoice-registration-pharmacy-summary-field.php' );
        }
    }
}
