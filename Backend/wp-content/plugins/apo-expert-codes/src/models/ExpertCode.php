<?php

namespace apo\expertcodes\models;

use awsm\wp\libraries\Model;

class ExpertCode extends Model
{
    protected $fillable = [
        'expert_code',
        'sales_rep_user_id',
        'expert_code_name',
        'usages',
        'used',
    ];

    protected $unique = [
        'expert_code',
        'sales_rep_user_id',
    ];

	public function __construct() 
	{
        parent::__construct('expert_codes');
    }

	
}
