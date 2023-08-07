<?php

namespace apo\svy\rest;
use awsm\wp\libraries\rest\RegisterRestField;
use apo\svy\controllers\ResultsSurveyController;
use apo\svy\rest\Routes;

class SurveyRestFields extends RegisterRestField
{

    public function __construct()
    {
        parent::__construct('surveys');
    }

    public function register()
    {
        $this->registerStoreEndpoint();
    }

    public function registerResult()
    {
        $this->registerRestField('result', [
            'get_callback' => [new ResultsSurveyController, 'showResult'],
            'schema' => array(
                'description' => 'Show user result for the given survey',
                'type'        => 'array'
            ),
        ]);
        return $this;
    }

    public function registerIsComplete()
    {
        $this->registerRestField('is_complete', [
            'get_callback' => [new ResultsSurveyController, 'showIsComplete'],
            'schema' => array(
                'description' => 'Shows if the user has completed the given survey',
                'type'        => 'boolean'
            ),
        ]);
        return $this;
    }

    public function registerStoreEndpoint()
    {
        $this->registerRestField('storeEndpoint', [
            'get_callback' => function($object) {
                return '/' . Routes::ROUTE_NAMESPACE . '/' . Routes::BASE_V1 . '/results';
            },
            'schema' => array(
                'description' => 'Send a POST Request to this endpoint to store a user answer',
                'type'        => 'string'
            ),
        ]);
        return $this;
    }

}