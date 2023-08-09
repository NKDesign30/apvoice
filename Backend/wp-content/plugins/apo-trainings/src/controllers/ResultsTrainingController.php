<?php

namespace apo\trng\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;
use awsm\wp\libraries\utilities\Auth;
use apo\trng\models\Training;
use apo\trng\models\Lesson;

class ResultsTrainingController extends Controller
{
    use Auth;

	public function __construct() 
	{
        parent::__construct();
        $this->model = new Training();
        $this->lessonModel = new Lesson();
	}

	public function index( Request $request )
   {  
       $training = $this->model->showByTraining($request->get_param('id'));
       return $this->prepareResponse($training);
    }

     /**
     * Additional rest fields
     */
    public function getTrainingResults($object)
    {
      $trainings = $this->model->showByUser();
      $lessons = $this->lessonModel->showByUser();

      $result = [];

      if(is_array($trainings) && count($trainings) > 0){
         foreach($trainings as $training){
            $result[$training->training_id] = Array(
                                             'is_complete' => $training->is_complete,
                                             'completed_lessons' => []
                                          );
         }
      }

      if(is_array($lessons) && count($lessons) > 0){
         foreach($lessons as $lesson){
            $result[$lesson->training_id]['completed_lessons'][$lesson->lesson_id] = $lesson->lesson_id;
         }
      }

      return $result;
    }

    public function showResult($object)
    {
       $training = $this->model->showByTraining($object['id']);
       return $this->prepareResponse($training->result);
    }

    public function showIsComplete($id)
    {
       $training = $this->model->showByTraining($id);
       return (boolean) $this->prepareResponse($training->is_complete);
    }

   public function registerParticipation(Request $request){
      $data = array_merge($request->get_params(), ['user_id' => $this->userId()]);

      $currentTraining = $this->model->showByTraining($data['training_id']);

      if(!$currentTraining) {
         $training = $this->model->create($data);
      }

      return true;
   }

} 