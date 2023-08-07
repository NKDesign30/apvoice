<?php

namespace apo\expertpoints\rest;
use awsm\wp\libraries\rest\RegisterRestField;
use apo\expertpoints\models\ExpertPoint;

class UserRestFields extends RegisterRestField
{

    public function __construct()
    {
        parent::__construct('user');
    }

    public function register()
    {
        $this->registerUserExpertPoints();
    }

    public function registerUserExpertPoints()
    {
        $this->registerRestField('expertPoints', [
            'get_callback' => [new ExpertPoint, 'getUsersExpertPoints'],
            'schema' => array(
                'description' => 'Show users expert point summary',
                'type'        => 'number'
            ),
        ]);
        return $this;
    }

}