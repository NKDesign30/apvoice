<?php
/*
Plugin Name: Gravity Forms apovoice Registration Pharmacy Summary Add-On
Plugin URI: https://www.awsm.rocks
Description: Adds a special field for the registration forms, which includes a summary of the Pharmacy registering for and allows to add more Pharmacies.
Version: 1.0.0
Author: AWESOME! Software GmbH
Author URI: https://www.awsm.rocks
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: apovoiceregistrationpharmacysummary
*/

define( 'GF_APOVOICE_REGISTRATION_PHARMACY_SUMMARY_ADDON_VERSION', '1.0.0' );

add_action( 'gform_loaded', array( 'GF_Apovoice_Registration_Pharmacy_Summary_AddOn_Bootstrap', 'load' ), 5 );

class GF_Apovoice_Registration_Pharmacy_Summary_AddOn_Bootstrap {

    public static function load() {
        if ( ! method_exists( 'GFForms', 'include_addon_framework' ) ) {
            return;
        }

        require_once( 'class-apovoiceregistrationpharmacysummary.php' );

        GFAddOn::register( 'GFApovoiceRegistrationPharmacySummaryAddOn' );
    }

}
