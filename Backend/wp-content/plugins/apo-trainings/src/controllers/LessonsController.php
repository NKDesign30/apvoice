<?php

namespace apo\trng\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;
use awsm\wp\libraries\utilities\Auth;
use apo\trng\models\Lesson;

class LessonsController extends Controller
{
    use Auth;

	public function __construct() 
	{
        parent::__construct();
        $this->model = new Lesson();
	}

     /**
     * Additional rest fields
     */
    public function showCompleted($training)
    {
        $lessons = $this->model->getCompletedLessons($training);
        return $this->prepareResponse($lessons);
    }

} 