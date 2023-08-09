<?php

namespace apo\reporting\models;

use apo\reporting\queries\TotalUsersPerUserRoleQuery;
use apo\reporting\utilities\CreateStatsTrait;
use awsm\wp\libraries\Model;

class ReportingKpiTotalUsersPerUserRole extends Model 
{
    use CreateStatsTrait, TotalUsersPerUserRoleQuery;

    protected $fillable = [
        'user_role',
        'total_users',
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
        parent::__construct('apo_reporting_kpi_total_users_per_user_role');
    }

    public function run($startDate, $endDate, $role, $granularity = null)
    {
        return $this->createStats(
            $this->getTotalUsersPerUserRoleForSpecificPeriod($startDate, $endDate, $role, $granularity)
        );
    }

    public function getReportingResults($startDate, $endDate, $role, $granularity = null)
    {
        return $this->getTotalUsersPerUserRoleForSpecificPeriod($startDate, $endDate, $role, $granularity);
    }
	
}
