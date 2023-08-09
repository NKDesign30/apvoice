<?php

namespace apo\migration\models;

use awsm\wp\libraries\Model;

class MigrationStatus extends Model
{
    protected $fillable = [
        'trainings_migrated',
        'surveys_migrated',
        'users_migrated',
        'survey_user_results_migrated',
        'training_quiz_results_migrated',
        'voucher_codes_migrated',
        'expert_codes_migrated',
    ];

	public function __construct() 
	{
        parent::__construct('apo_migration_status');
    }
	
}
