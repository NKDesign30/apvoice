<?php

namespace apo\apopoints\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;
use awsm\wp\libraries\utilities\Auth;
use apo\apopoints\models\ApoPoint;
use apo\apopoints\verifier\ApoPointsVerifier;

class ApoPointsUserController extends Controller
{
    use Auth;

	public function __construct() 
	{
        parent::__construct();
        $this->model = new ApoPoint();
	}

	public function index( Request $request )
    {  
       $response = $this->model->getUsersApoPoints();
       return $this->prepareResponse(['apo_points' => $response]);
    }

    public function store( Request $request )
    {
        $verifier = new ApoPointsVerifier();
        
        $verifiedData = $verifier->verify($request->get_params());
        
        if( is_wp_error($verifiedData)) {
            return $verifiedData;
        } 
        
        $response = $this->model->create($verifiedData);
        return $this->prepareResponse($response);
    }

} 