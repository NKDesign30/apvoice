<?php

namespace apo\rxts\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;

class PageUserRolePermissionsController extends Controller
{

	public function __construct()
	{
        parent::__construct();
	}

    public function index( Request $request )
    {
        $pagePermissions = array_map(function($page) {
            return [
                'id' => $page->ID,
                'template' => get_page_template_slug($page->ID),
                'user_role_permissions' => get_post_meta($page->ID, 'apo_user_access_permissions')[0],
            ];
        }, get_pages() );

        return $this->prepareResponse($pagePermissions);
    }


}
