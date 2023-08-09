<?php

namespace apo\trng\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;
use awsm\wp\libraries\utilities\Auth;
use apo\trng\models\Training;

class ResultsUserController extends Controller
{
    use Auth;

	public function __construct() 
	{
        parent::__construct();
        $this->model = new Training();
	}

	public function index( Request $request )
    {  
       $userResults = $this->model->showByUser();
       return $this->prepareResponse($userResults);
    }

} 