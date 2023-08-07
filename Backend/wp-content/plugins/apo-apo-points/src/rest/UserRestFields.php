<?php

namespace apo\apopoints\rest;
use awsm\wp\libraries\rest\RegisterRestField;
use apo\apopoints\models\ApoPoint;

class UserRestFields extends RegisterRestField
{

    public function __construct()
    {
        parent::__construct('user');
    }

    public function register()
    {
        $this->registerUserApoPoints();
    }

    public function registerUserApoPoints()
    {
        $this->registerRestField('apoPoints', [
            'get_callback' => [new ApoPoint, 'getUsersApoPoints'],
            'schema' => array(
                'description' => 'Show users apo point summary',
                'type'        => 'number'
            ),
        ]);
        return $this;
    }

}