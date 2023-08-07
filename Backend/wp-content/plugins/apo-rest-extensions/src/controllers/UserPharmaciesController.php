<?php

namespace apo\rxts\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;

class UserPharmaciesController extends Controller
{
	public function __construct()
	{
        parent::__construct();
    }

    public function index($object) {
        global $wpdb;

        $user_id = $object['id'];

        $sql = $wpdb->prepare( "
            SELECT
                `{$wpdb->prefix}apovoice_pharmacies`.*
            FROM
                `{$wpdb->prefix}apovoice_pharmacy_user`
                JOIN
                    `{$wpdb->prefix}apovoice_pharmacies`
                ON
                    `{$wpdb->prefix}apovoice_pharmacies`.`id` = `{$wpdb->prefix}apovoice_pharmacy_user`.`pharmacy_id`
            WHERE
                `{$wpdb->prefix}apovoice_pharmacy_user`.`user_id` = %d
        ", array( $user_id ) );

        $pharmacy_ids = $wpdb->get_results( $sql );

        return $pharmacy_ids;
    }
}
