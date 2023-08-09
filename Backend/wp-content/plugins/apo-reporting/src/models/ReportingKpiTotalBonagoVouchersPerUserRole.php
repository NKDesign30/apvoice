<?php

namespace apo\reporting\models;

use awsm\wp\libraries\Model;
use apo\reporting\utilities\CreateStatsTrait;
use apo\reporting\queries\TotalBonagoVouchersPerUserRoleQuery;

class ReportingKpiTotalBonagoVouchersPerUserRole extends Model 
{
    use CreateStatsTrait, TotalBonagoVouchersPerUserRoleQuery;

    protected $fillable = [
        'user_role',
        'total_exchanged_expert_points_into_bonago_vouchers',
        'total_redeemed_bonago_vouchers',
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
        parent::__construct('apo_reporting_kpi_total_bonago_vouchers_per_user_role');
    }

    public function run($startDate, $endDate, $role, $granularity = null)
    {
        return $this->createStats(
            $this->getTotalBonagoVouchersPerUserRoleForSpecificPeriod($startDate, $endDate, $role, $granularity)
        );
    }

    public function getReportingResults($startDate, $endDate, $role, $granularity = null)
    {
        return $this->getTotalBonagoVouchersPerUserRoleForSpecificPeriod($startDate, $endDate, $role, $granularity);
    }
	
}
