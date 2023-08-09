<?php

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();


delete_option('hsso_message');
delete_option('hsso_endpoint');
