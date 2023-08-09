<?php

namespace apo\reporting\models;

use awsm\wp\libraries\Model;
use apo\reporting\utilities\CreateStatsTrait;
use apo\reporting\queries\TotalRegisteredPharmaciesQuery;

class ReportingKpiTotalRegisteredPharmaciesPerSalesRep extends Model 
{
    use CreateStatsTrait, TotalRegisteredPharmaciesQuery;

    protected $fillable = [
        'sales_rep_user_id',
        'total_registered_pharmacies',
        'start_date',
        'end_date',
        'granularity',
    ];

    protected $unique = [
        'sales_rep_user_id',
        'start_date',
        'end_date',
        'granularity',
    ];

	public function __construct() 
	{
        parent::__construct('apo_reporting_kpi_total_registered_pharmacies_per_sales_rep');
    }

    public function run($startDate, $endDate, $granularity = null)
    {
        $result = [];
        foreach ($this->getTotalRegisteredPharmaciesPerSalesRepForSpecificPeriod($startDate, $endDate, $granularity) as $stats) {
            $result[] = $this->createStats($stats);
        }
        return $result;
    }

    public function getReportingResults($startDate, $endDate, $granularity = null)
    {
        return $this->getTotalRegisteredPharmaciesPerSalesRepForSpecificPeriod($startDate, $endDate, $granularity);
    }
	
}
