<?php

namespace dwnld\models;

use awsm\wp\libraries\Model;

class Download extends Model
{
	public function __construct() 
	{
        parent::__construct('apo_downloads');
    }
	
}
