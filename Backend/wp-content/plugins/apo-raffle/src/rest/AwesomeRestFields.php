<?php

namespace raffle\rest;

use awsm\wp\libraries\rest\RegisterRestField;
use raffle\rest\routes\Raffle;

class AwesomeRestFields extends RegisterRestField
{

    public function __construct()
    {
        parent::__construct('awesome');
    }

    public function register()
    {

    }

}