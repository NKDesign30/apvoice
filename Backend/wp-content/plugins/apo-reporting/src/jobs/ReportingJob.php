<?php

namespace apo\reporting\jobs;

use apo\reporting\interfaces\Dispatchable;
use apo\reporting\jobs\types\Report;

class ReportingJob implements Dispatchable
{

    /**
     * Define roles which a relevant for the statistics
     * all other roles are omitted
     */
    const REPORTING_USER_ROLES = [
        'administrator', 
        'detailer',
        'hcp',
        'pg_admin',
        'pg_member',
        'pg_member',
        'regional_manager_detailer',
        'regional_manager_sales_rep',
        'sales_rep',
    ];

    protected $report;

    protected $args;

	public function __construct(...$args) 
	{
        $this->report = array_shift($args);
        $this->args = $args;

        $this->setup();
    }
    
    public function dispatch()
    {
        return (new $this->report(...$this->args))->dispatch();
    }

    public function setup()
    {
        $this->createReportingPeriod()
            ->generateReportClass();
    }

    public function generateReportClass()
    {
        $this->report = __NAMESPACE__ . '\\' . $this->report;
        return $this;
    }

    public function createReportingPeriod()
    {
        for ($i=0; $i < 2; $i++) {
            $this->createReportingDate($this->args[$i], $i);
        }
        return $this;
    }

    public function createReportingDate(&$arg, $i) 
    {
        if ( !isset ($arg) ) {

            switch ($this->report) {
                case Report::DAILY:
                    $arg = $this->convertStringToDate('last day');
                    break;
                case Report::WEEKLY:
                    $arg = $i === 0 ? 
                        $this->convertStringToDate('last monday',  strtotime($this->convertStringToDate('last sunday'))) : 
                        $this->convertStringToDate('last sunday');
                    break;
                case Report::MONTHLY:
                    $arg = $i === 0 ? 
                        $this->convertStringToDate('first day of last month') : 
                        $this->convertStringToDate('last day of last month');
                    break;
                case Report::YEARLY:
                    $arg = $i === 0 ? 
                        $this->convertStringToDate('last year first day of january') : 
                        $this->convertStringToDate('last year last day of december');
                    break;
                case Report::YEAR_TO_DATE:
                    $arg = $i === 0 ? null : $this->convertStringToDate('now');
                    break;
            }

        }

        return $this;
    }

    public function convertStringToDate($string, $time = null)
    {
        if( is_null($time) ) $time = time();

        return date('Y-m-d', strtotime($string, $time));
    }



} 