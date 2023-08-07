<?php

namespace apo\rxts\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;

class SalesRepExpertCodeController extends Controller
{
	public function __construct()
	{
        parent::__construct();
	}

    public function index( Request $request )
    {
        global $wpdb;

        $expertCode =  $request->get_param('expert_code');

        $sql = $wpdb->prepare("
            SELECT 
                `sales_rep_user_id` as `user_id`
            FROM `{$wpdb->prefix}expert_codes`
            WHERE 
            `expert_code` = %s
            LIMIT 1
        ", $expertCode);

        $result = $wpdb->get_row($sql);
        
        if($result === null)
            return null;

        return [
            'name' => get_user_meta($result->user_id, 'first_name', true) . ' ' . get_user_meta($result->user_id, 'last_name', true),
        ];
    }
}
