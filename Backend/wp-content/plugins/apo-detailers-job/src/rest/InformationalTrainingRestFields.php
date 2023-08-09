<?php

namespace apo\detailersjob\rest;

use awsm\wp\libraries\rest\RegisterRestField;
use apo\detailersjob\cpt\InformationalTraining;

class InformationalTrainingRestFields extends RegisterRestField
{
    public function __construct()
    {
        parent::__construct(InformationalTraining::SLUG);
    }

    public function register()
    {
        //
    }
}
