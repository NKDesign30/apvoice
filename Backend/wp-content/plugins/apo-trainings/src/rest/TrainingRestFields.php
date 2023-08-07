<?php

namespace apo\trng\rest;

use awsm\wp\libraries\rest\RegisterRestField;
use apo\trng\controllers\ResultsTrainingController;
use apo\trng\rest\routes\Results;
use apo\trng\cpt\Training;

class TrainingRestFields extends RegisterRestField
{

    public function __construct()
    {
        parent::__construct(Training::SLUG);
    }

    public function register()
    {
        $this->registerResult()
            // ->registerIsComplete()
            ->registerStoreEndpoint();
    }

    public function registerResult()
    {
        $this->registerRestField('result', [
            'get_callback' => [new ResultsTrainingController, 'showResult'],
            'schema' => array(
                'description' => 'Show user result for the given training',
                'type'        => 'array'
            ),
        ]);
        return $this;
    }

    public function registerIsComplete()
    {
        $this->registerRestField('is_complete', [
            'get_callback' => [new ResultsTrainingController, 'showIsComplete'],
            'schema' => array(
                'description' => 'Shows if the user has completed the given training',
                'type'        => 'boolean'
            ),
        ]);
        return $this;
    }

    public function registerStoreEndpoint()
    {
        $this->registerRestField('storeEndpoint', [
            'get_callback' => function($object) {
                return '/' . Results::ROUTE_NAMESPACE . '/' . Results::BASE_V1 . '/results';
            },
            'schema' => array(
                'description' => 'Send a POST Request to this endpoint to store a user training',
                'type'        => 'string'
            ),
        ]);
        return $this;
    }

}