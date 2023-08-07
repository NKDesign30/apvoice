<?php

require_once('headless-sso.php');

function hsso_save_setting(){
	$headless = new headless_sso();

	if($headless->hsso_check_option_admin_referer('hsso_general_settings')) {
        
        if(array_key_exists("hsso_endpoint",$_POST)) {
            $endpoint = esc_url_raw($_POST['hsso_endpoint']);
            update_option('hsso_endpoint',$endpoint);
        }
        update_option( 'hsso_message', 'Endpoint added successfully.');

        return;
	}


}