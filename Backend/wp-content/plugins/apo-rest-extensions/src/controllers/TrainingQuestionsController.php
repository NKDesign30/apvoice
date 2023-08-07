<?php 

namespace apo\rxts\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;
use awsm\wp\libraries\utilities\Auth;
use apo\rxts\models\TrainingQuestion;

class TrainingQuestionsController extends Controller 
{

    use Auth;

    public function __construct() 
	{
        parent::__construct();
        $this->model = new TrainingQuestion();
    }
    
    public function index( Request $request )
    {  
       $trainingQuestions = $this->model->show();
       return $this->prepareResponse($trainingQuestions);
    }

    public function store( Request $request )
    {
        $data = array_merge($request->get_params(), ['user_id' => $this->userId()]);

        /** @todo implement validation as soon as it is known what */
        $result = $this->model->createOrUpdate([
            'user_id' => $data['user_id'],
            'training_id' => $data['training_id'],
            'question_id' => $data['question_id'],
            'lesson_id' => $data['lesson_id'],
            'question_type' => $data['question_type'],
            'result' => $data['result'],
        ]);

        return $this->prepareResponse($result);
    }
}