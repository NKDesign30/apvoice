<?php

namespace apo\svy\controllers;

use awsm\wp\libraries\Controller;
use awsm\wp\libraries\utilities\Auth;
use apo\svy\models\Result;
use apo\expertpoints\controllers\ExpertPointsUserController;
use \WP_REST_Request as Request;

class ResultsController extends Controller
{
    use Auth;

	public function __construct() 
	{
        parent::__construct();
        $this->model = new Result();
	}

	public function index( Request $request )
    {  
       $result = $this->model->show();
       return $this->prepareResponse($result);
    }

    public function store( Request $request )
    {
        $data = array_merge($request->get_params(), ['user_id' => $this->userId(), 'is_complete' => 1]);

        $validation = $this->validateUserAnwsers($data['result']);
        if($validation) {
            return new \WP_Error('validation_error', $validation, ['status' => 422]);
        }
 
        $result = $this->model->create($data);

        $this->associateExpertPoints($result);

        return $this->prepareResponse($result);
    }

    protected function associateExpertPoints(&$surveyResult)
    {
        if( property_exists($surveyResult, 'survey_id') ) {
            $expertPointsRequest = new Request();
            $expertPointsRequest->set_param('related_type', 'survey');
            $expertPointsRequest->set_param('related_id', $surveyResult->survey_id);
            $expertPointsController = new ExpertPointsUserController();
            $expertPoints = $expertPointsController->store($expertPointsRequest);
            $surveyResult->points_earned = $expertPoints['points_earned'];
        }
    }

    private function validateUserAnwsers($userAnwsers)
    {
        $userAnwsers = maybe_unserialize( $userAnwsers );
        //print_r($userAnwsers);

        $validation = array_filter($userAnwsers, function($anwser) {
            return 
                ( $anwser['type'] !== 'question_cluster' ) && 
                (( !array_key_exists('value', $anwser) ) ||
                ( !array_key_exists('is_optional', $anwser) && empty($anwser['value']) ) ||
                ( !$anwser['is_optional'] && empty($anwser['value']) ))
            ;
        });

        $validation =  array_map(function($v) {
            $v['error_message'] = __('This field is required', 'svy');
            return $v;
        }, $validation);

        if(!$validation) return null;

        return $validation;
    }

} 