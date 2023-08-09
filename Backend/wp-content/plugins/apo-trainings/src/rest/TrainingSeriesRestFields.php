<?php

namespace apo\trng\rest;

use awsm\wp\libraries\rest\RegisterRestField;
use apo\trng\controllers\AssociatedTrainingsController;
use apo\trng\rest\routes\Results;
use apo\trng\cpt\TrainingSeries;

class TrainingSeriesRestFields extends RegisterRestField
{

    public function __construct()
    {
        parent::__construct(TrainingSeries::SLUG);
    }

    public function register()
    {
        $this->registerTrainings()
            ->registerStoreEndpoint();
    }

    public function registerTrainings()
    {
        $this->registerRestField('trainings', [
            'get_callback' => [new AssociatedTrainingsController, 'associate'],
            'schema' => array(
                'description' => 'Show associated trainings for the given training series',
                'type'        => 'array'
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