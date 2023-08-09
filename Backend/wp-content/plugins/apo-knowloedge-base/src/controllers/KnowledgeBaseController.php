<?php

namespace knwldg\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;
use awsm\wp\libraries\utilities\Auth;
use knwldg\models\KnowledgeBase;

class KnowledgeBaseController extends Controller
{
    use Auth;

	public function __construct() 
	{
        parent::__construct();
        $this->model = new KnowledgeBase();
	}

	public function index( Request $request )
    {  
       $result = $this->model->show();
       return $this->prepareResponse($result);
    }

    public function store( Request $request )
    {
        $data = array_merge($request->get_params(), ['blog_id' => get_current_blog_id(), 'user_id' => $this->userId()]);
        $result = $this->model->create($data);
        return $this->prepareResponse($result);
    }

    public function show( Request $request )
    {  
       $result = $this->model->showOne($request->get_param('id'));
       return $this->prepareResponse($result);
    }

} 