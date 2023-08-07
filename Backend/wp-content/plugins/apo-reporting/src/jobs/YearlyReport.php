<?php

namespace apo\reporting\jobs;

use apo\reporting\jobs\BaseReport;
use apo\reporting\jobs\types\Granularity;
use apo\reporting\interfaces\Dispatchable;
use apo\reporting\models\ReportingKpiTotalUsersPerUserRole;
use apo\reporting\models\ReportingKpiTotalSurveysPerUserRole;
use apo\reporting\models\ReportingKpiTotalRegisteredPharmacies;
use apo\reporting\models\ReportingKpiTotalTrainingsPerUserRole;
use apo\reporting\models\ReportingKpiTotalBonagoVouchersPerUserRole;
use apo\reporting\models\ReportingKpiTotalRegisteredPharmaciesPerSalesRep;

class YearlyReport extends BaseReport implements Dispatchable
{
	public function __construct(...$args) 
	{
        parent::__construct($args, Granularity::YEARLY);

        $this->addUserRoleKpi(new ReportingKpiTotalTrainingsPerUserRole())
            ->addUserRoleKpi(new ReportingKpiTotalSurveysPerUserRole())
            ->addUserRoleKpi(new ReportingKpiTotalBonagoVouchersPerUserRole())
            ->addUserRoleKpi(new ReportingKpiTotalUsersPerUserRole())
            ->addBasicKpi(new ReportingKpiTotalRegisteredPharmacies())
            ->addBasicKpi(new ReportingKpiTotalRegisteredPharmaciesPerSalesRep());
    }
    
    public function dispatch() 
    {
        $this->dispatchBasicKpis()
            ->dispatchUserRoleKpis();

        return $this->kpiResults;
    }

} 