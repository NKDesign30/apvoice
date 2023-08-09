<?php

namespace apo\expertpoints\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;
use awsm\wp\libraries\utilities\Auth;
use apo\expertpoints\models\ExpertPoint;
use apo\expertpoints\verifier\ExpertPointsVerifier;

class ExpertPointsUserController extends Controller
{
    use Auth;

	public function __construct() 
	{
        parent::__construct();
        $this->model = new ExpertPoint();
	}

	public function index( Request $request )
    {  
       $response = $this->model->getUsersExpertPoints();
       return $this->prepareResponse(['expert_points' => $response]);
    }

    public function store( Request $request )
    {
        $verifier = new ExpertPointsVerifier();
        
        $verifiedData = $verifier->verify($request->get_params());
        
        if( is_wp_error($verifiedData)) {
            return $verifiedData;
        } 
        
        $response = $this->model->create($verifiedData);
        return $this->prepareResponse($response);
    }

} 