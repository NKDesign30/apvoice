<?php

namespace apo\svy\controllers;

use awsm\wp\libraries\Controller;
use awsm\wp\libraries\utilities\Auth;
use apo\svy\models\Result;

class ResultsSurveyController extends Controller
{
    use Auth;

	public function __construct() 
	{
        parent::__construct();
        $this->model = new Result();
	}

	public function index( \WP_REST_Request $request )
    {  
       $results = $this->model->showBySurvey($request->get_param('id'));
       return $this->prepareResponse($results);
    }

    public function getSurveyResults($object){
       $surveys = $this->model->showByUser();
       $result = [];
       if(is_array($surveys) && count($surveys) > 0){
          foreach($surveys as $survey){
             $result[$survey->survey_id] = Array(
                                                   "is_complete" => $survey->is_complete,
                                                   "result" => maybe_unserialize($survey->result)
                                                );
          }
       }
       return $result;
    }

    /**
     * Additional rest fields
     */
    public function showResult($object)
    {
       $survey = $this->model->showBySurvey($object['id']);
       return $this->prepareResponse($survey->result);
    }

    public function showIsComplete($object)
    {
       $survey = $this->model->showBySurvey($object['id']);
       return (boolean) $this->prepareResponse($survey->is_complete);
    }

} 