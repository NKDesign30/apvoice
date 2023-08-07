<?php

namespace dwnld\rest;

use awsm\wp\libraries\rest\RegisterRestField;

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