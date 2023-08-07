<?php
/*
Plugin Name: Gravity Forms apovoice Registration Information Add-On
Plugin URI: https://www.awsm.rocks
Description: Adds a special field for the registration forms, which includes an expandable link that shows a hint on how to obtain information required for the registration process.
Version: 1.0.0
Author: AWESOME! Software GmbH
Author URI: https://www.awsm.rocks
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: apovoiceregistrationinformation
*/

define( 'GF_APOVOICE_REGISTRATION_INFORMATION_ADDON_VERSION', '1.0.0' );

add_action( 'gform_loaded', array( 'GF_Apovoice_Registration_Information_AddOn_Bootstrap', 'load' ), 5 );

class GF_Apovoice_Registration_Information_AddOn_Bootstrap {

    public static function load() {
        if ( ! method_exists( 'GFForms', 'include_addon_framework' ) ) {
            return;
        }

        require_once( 'class-apovoiceregistrationinformation.php' );

        GFAddOn::register( 'GFApovoiceRegistrationInformationAddOn' );
    }

}
