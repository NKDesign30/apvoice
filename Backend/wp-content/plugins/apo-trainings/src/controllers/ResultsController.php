<?php

namespace apo\trng\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;
use awsm\wp\libraries\utilities\Auth;
use apo\trng\models\Training;
use apo\trng\models\Lesson;

class ResultsController extends Controller
{
    use Auth;

    private $lesson;

	public function __construct() 
	{
        parent::__construct();
        $this->model = new Training();
        $this->lesson = new Lesson();
	}

	public function index( Request $request )
    {  
       $training = $this->model->show();
       return $this->prepareResponse($training);
    }

    public function store( Request $request )
    {
        $data = array_merge($request->get_params(), ['user_id' => $this->userId()]);

        $currentTraining = $this->model->showByTraining($data['training_id']);

        if($currentTraining) {
            $training = $this->model->update(
                ['result' => $this->appendResult($currentTraining, $data['result'])], 
                ['training_id' => $data['training_id'], 'user_id' => $this->userId()]
            );
        } else {
            $training = $this->model->create($data);
        }

        $trainings = $this->model->update_user_apo_points($training->training_id, $data);

        $this->lesson->createOrUpdate([
            'training_id' => $training->training_id,
            'user_id' => $training->user_id,
            'lesson_id' => $data['lesson_id'],
        ]);

        if($this->hasFinishedLessons($training)) {
            $training = $this->model->finish($training->training_id);
        }

        return $this->prepareResponse($training);
    }

    public function show( Request $request )
    {  
       $training = $this->model->showOne($request->get_param('id'));
       return $this->prepareResponse($training);
    }

    protected function appendResult($training, $result) 
    {
        $currentResult = maybe_unserialize($training->result);
        $result = $this->flattenFirstLevel($result);

        $index = array_keys(
            array_filter($currentResult, function($current) use($result) {
                return $current['lesson_id'] === $result['lesson_id'];
            })
        )[0];

        if(!is_null($index)) {
            $currentResult[$index] = $result;
        } else {
            $currentResult[] = $result;
        }

        return maybe_serialize($currentResult);
    }

    private function flattenFirstLevel($data) 
    {
        $data = maybe_unserialize($data);
        if(is_array($data)) {
            return call_user_func_array('array_merge', $data);
        }
        return $data;
    }

    private function hasFinishedLessons($training)
    {
        $currentLessonIds = Array();
        foreach(maybe_unserialize($training->result) AS $id => $lesson){
            if(isset($lesson['is_legacy'])){
                $leg_data = maybe_unserialize($lesson['legacy_data']);
                if($leg_data[$id]['complete'] == 0){
                    $currentLessonIds[] = "";
                    continue;
                }
            }
            $currentLessonIds[] = $lesson['lesson_id'];
        }

        return count(array_intersect($currentLessonIds, $this->lesson->getLessonIds($training->training_id))) == count($this->lesson->getLessonIds($training->training_id));
    }

} 