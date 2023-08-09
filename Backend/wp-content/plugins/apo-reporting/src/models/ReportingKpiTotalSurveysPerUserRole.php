<?php

namespace apo\reporting\models;

use awsm\wp\libraries\Model;
use apo\reporting\utilities\CreateStatsTrait;
use apo\reporting\queries\TotalSurveysPerUserRoleQuery;

class ReportingKpiTotalSurveysPerUserRole extends Model 
{
    use CreateStatsTrait, TotalSurveysPerUserRoleQuery;

    protected $fillable = [
        'user_role',
        'total_surveys',
        'completed_surveys',
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
        parent::__construct('apo_reporting_kpi_surveys_per_user_role');
    }

    public function run($startDate, $endDate, $role, $granularity = null)
    {
        return $this->createStats(
            $this->getTotalSurveysPerUserRoleForSpecificPeriod($startDate, $endDate, $role, $granularity)
        );
    }

    public function getReportingResults($startDate, $endDate, $role, $granularity = null)
    {
        return $this->getTotalSurveysPerUserRoleForSpecificPeriod($startDate, $endDate, $role, $granularity);
    }
	
}
