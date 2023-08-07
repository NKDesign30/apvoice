<?php

namespace apo\detailersjob\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;
use awsm\wp\libraries\utilities\Auth;
use apo\detailersjob\models\InformationalTraining;
use apo\detailersjob\models\Lesson;

class InformationalTrainingsController extends Controller
{
    use Auth;

	public function __construct()
	{
        parent::__construct();

        $this->model = new InformationalTraining();
	}

	public function index( Request $request )
    {
        return $this->prepareResponse( $this->model->all( $this->userId() ) );
    }

    public function store( Request $request )
    {
        return $this->prepareResponse( $this->model->saveState( $request->get_params() ) );
    }

    public function destroy( Request $request )
    {
        $this->model->clearSavedState( $request->get_params() );
    }
}
