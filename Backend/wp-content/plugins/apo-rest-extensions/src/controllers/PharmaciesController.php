<?php

namespace apo\rxts\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;

class PharmaciesController extends Controller
{
	public function __construct()
	{
        parent::__construct();
	}

    public function index( Request $request )
    {
        global $wpdb;
        $data_id = $request->get_param('id');
        $locale = get_locale();

        if($data_id === null) {
            if($locale == "de_DE" ||  $locale == "de_AT")
                $data = $wpdb->get_results( "SELECT * FROM `{$wpdb->prefix}apovoice_pgci`" );
            else
                $data = $wpdb->get_results( "SELECT * FROM `{$wpdb->prefix}apovoice_pharmacies`" );

        } else {
            if($locale == "de_DE" ||  $locale == "de_AT")
                $data = array_shift($wpdb->get_results( "SELECT * FROM `{$wpdb->prefix}apovoice_pgci` WHERE pg_customer_id = '".$data_id."'" ));
            else
                $data = array_shift($wpdb->get_results( "SELECT * FROM `{$wpdb->prefix}apovoice_pharmacies` WHERE pharmacy_unique_number = '".$data_id."'" ));
        }



        return $data;
    }
}
