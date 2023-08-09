<?php

namespace apo\reporting\models;

use awsm\wp\libraries\Model;
use apo\reporting\utilities\CreateStatsTrait;
use apo\reporting\queries\TotalRegisteredPharmaciesQuery;

class ReportingKpiTotalRegisteredPharmacies extends Model 
{
    use CreateStatsTrait, TotalRegisteredPharmaciesQuery;

    protected $fillable = [
        'total_registered_pharmacies',
        'start_date',
        'end_date',
        'granularity',
    ];

    protected $unique = [
        'start_date',
        'end_date',
        'granularity',
    ];

	public function __construct() 
	{
        parent::__construct('apo_reporting_kpi_total_registered_pharmacies');
    }

    public function run($startDate, $endDate, $granularity = null)
    {
        return $this->createStats( 
            $this->getTotalRegisteredPharmaciesForSpecificPeriod($startDate, $endDate, $granularity)
        );
    }

    public function getReportingResults($startDate, $endDate, $granularity = null)
    {
        return $this->getTotalRegisteredPharmaciesForSpecificPeriod($startDate, $endDate, $granularity);
    }
	
}
