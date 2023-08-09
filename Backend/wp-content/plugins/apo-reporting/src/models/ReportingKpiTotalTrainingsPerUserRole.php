<?php

namespace apo\reporting\models;

use awsm\wp\libraries\Model;
use apo\reporting\utilities\CreateStatsTrait;
use apo\reporting\queries\TotalTrainingsPerUserRoleQuery;

class ReportingKpiTotalTrainingsPerUserRole extends Model 
{
    use CreateStatsTrait, TotalTrainingsPerUserRoleQuery;

    protected $fillable = [
        'user_role',
        'total_trainings',
        'completed_trainings',
        'start_date',
        'end_date',
        'granularity',
    ];

    protected $unique = [
        'user_role',
        'start_date',
        'end_date',
        'granularity',
    ];

	public function __construct() 
	{
        parent::__construct('apo_reporting_kpi_trainings_per_user_role');
    }

    public function run($startDate, $endDate, $role, $granularity = null)
    {
        return $this->createStats(
            $this->getTotalTrainingsPerUserRoleForSpecificPeriod($startDate, $endDate, $role, $granularity)
        );
    }

    public function getReportingResults($startDate, $endDate, $role, $granularity = null)
    {
        return $this->getTotalTrainingsPerUserRoleForSpecificPeriod($startDate, $endDate, $role, $granularity);
    }
	
}
