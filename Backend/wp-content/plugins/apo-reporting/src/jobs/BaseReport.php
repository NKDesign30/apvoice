<?php

namespace apo\reporting\jobs;

use apo\reporting\utilities\PruneUserRolesTrait;

class BaseReport
{
    use PruneUserRolesTrait;

    const BASIC_KPI = 'basic';

    const USER_ROLE_KPI = 'userRole';

    protected $startDate;
    
    protected $endDate;
    
    protected $args;

    protected $roles;

    protected $kpis;

    protected $kpiResults;

    private $granularity;

	public function __construct($args, $granularity) 
	{
        $this->startDate = $args[0];
        $this->endDate = $args[1];
        $this->args = $args;
        $this->kpis = [];
        $this->kpiResults = [];
        $this->granularity = $granularity;

        $this->pruneUnnecessaryRoles();
    }

    protected function dispatchBasicKpis()
    {
        foreach ($this->kpis[self::BASIC_KPI] as $kpi) {
            $this->kpiResults[self::BASIC_KPI][] = $kpi->run($this->startDate, $this->endDate, $this->granularity);
        }
        
        return $this;
    }

    protected function dispatchUserRoleKpis()
    {
        foreach ($this->kpis[self::USER_ROLE_KPI] as $kpi) {
            foreach ($this->getRoles() as $role) {
                $this->kpiResults[self::USER_ROLE_KPI][] = $kpi->run($this->startDate, $this->endDate, $role, $this->granularity);
            }
        }
        
        return $this;
    }

    protected function addKpi($key, $kpi) 
    {
        $this->kpis[$key][] = $kpi;
        return $this;
    }

    protected function addBasicKpi($kpi)
    {
        $this->addKpi(self::BASIC_KPI, $kpi);
        return $this;
    }

    protected function addUserRoleKpi($kpi)
    {
        $this->addKpi(self::USER_ROLE_KPI, $kpi);
        return $this;
    }

} 