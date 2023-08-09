<?php

namespace dwnld\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;
use awsm\wp\libraries\utilities\Auth;
use dwnld\models\Download;

class DownloadsController extends Controller
{
    use Auth;

	public function __construct() 
	{
        parent::__construct();
        $this->model = new Download();
	}

	public function index( Request $request )
    {  
       $result = $this->model->show();
       return $this->prepareResponse($result);
    }

    public function show( Request $request )
    {  
       $result = $this->model->showOne($request->get_param('id'));
       return $this->prepareResponse($result);
    }

} 