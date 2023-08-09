<?php

namespace apo\reporting\jobs;

use apo\reporting\models\DailyStats;
use apo\reporting\interfaces\Dispatchable;
use apo\reporting\utilities\DateRangeTrait;
use apo\reporting\models\DailyStatsPerSalesRep;
use apo\reporting\models\DailyStatsPerUserRole;
use apo\reporting\models\DailyStatsPerTrainingsCategory;
use apo\reporting\models\DailyStatsPerTrainingsCategoryPerUserRole;
use apo\reporting\models\DailyStatsPerJobRole;
use apo\reporting\models\DailyStatsPerDownload;
use apo\reporting\models\DailyStatsPerTraining;
use apo\reporting\models\DailyStatsPerSurvey;
use apo\reporting\models\DailyStatsPerActivation;
use apo\reporting\utilities\PruneUserRolesTrait;
use apo\reporting\utilities\JobRolesTrait;

class DailyStatistics implements Dispatchable
{

    use DateRangeTrait, PruneUserRolesTrait, JobRolesTrait;

    protected $roles;
    
    protected $date;

	public function __construct(...$args) 
	{
        $this->date = $args[0];

        $this->dailyStats = new DailyStats();
        $this->dailyStatsPerUserRole = new DailyStatsPerUserRole();
        $this->dailyStatsPerSalesRep = new DailyStatsPerSalesRep();
        $this->dailyStatsPerTrainingsCategory = new DailyStatsPerTrainingsCategory();
        $this->dailyStatsPerTrainingsCategoryPerUserRole = new DailyStatsPerTrainingsCategoryPerUserRole();
        $this->dailyStatsPerJobRole = new DailyStatsPerJobRole();
        $this->dailyStatsPerDownload = new DailyStatsPerDownload();
        $this->dailyStatsPerTraining = new DailyStatsPerTraining();
        $this->dailyStatsPerSurvey = new DailyStatsPerSurvey();
        $this->dailyStatsPerActivation = new DailyStatsPerActivation();

        $this->pruneUnnecessaryRoles();
        $this->pruneUnnecessaryJobRoles();
    }
    
    public function dispatch()
    {
        return $this->triggerAll();
    }

    /**
     * Dispatch all jobs for a specific date
     */
    protected function triggerAll()
    {
        $results = [];

        $results['dailyStats'] = $this->dispatchDailyStats();
        $results['dailyStatsPerUserRole'] = $this->dispatchDailyStatsPerUserRole();
        $results['dailyStatsPerSalesRep'] = $this->dispatchDailyStatsPerSalesRep();
        $results['dailyStatsPerTrainingCategory'] = $this->dispatchDailyStatsPerTrainingCategory();
        $results['dailyStatsPerTrainingCategoryPerUserRole'] = $this->dispatchDailyStatsPerTrainingCategoryPerUserRole();
        $results['dailyStatsPerJobRole'] = $this->dispatchDailyStatsPerJobRole();
        $results['dailyStatsPerDownload'] = $this->dispatchDailyStatsPerDownload();
        $results['dailyStatsPerTraining'] = $this->dispatchDailyStatsPerTraining();
        $results['dailyStatsPerSurvey'] = $this->dispatchDailyStatsPerSurvey();
        $results['dailyStatsPerActivation'] = $this->dispatchDailyStatsPerActivation();
        
        return $results;
    }

    protected function dispatchDailyStats()
    {
        return $this->dailyStats->run($this->date);
    }

    protected function dispatchDailyStatsPerUserRole()
    {
        $results = [];
        foreach ($this->getRoles() as $role) {
            $results[] = $this->dailyStatsPerUserRole->run($this->date, $role);
        }
        return $results;
    }

    protected function dispatchDailyStatsPerSalesRep()
    {
        return $this->dailyStatsPerSalesRep->run($this->date);
    }

    protected function dispatchDailyStatsPerTrainingCategory()
    {
        return $this->dailyStatsPerTrainingsCategory->run($this->date);
    }

    protected function dispatchDailyStatsPerDownload()
    {
        return $this->dailyStatsPerDownload->run($this->date);
    }

    protected function dispatchDailyStatsPerTraining()
    {
        return $this->dailyStatsPerTraining->run($this->date);
    }

    protected function dispatchDailyStatsPerSurvey()
    {
        return $this->dailyStatsPerSurvey->run($this->date);
    }

    protected function dispatchDailyStatsPerActivation()
    {
        return $this->dailyStatsPerActivation->run($this->date);
    }

    protected function dispatchDailyStatsPerTrainingCategoryPerUserRole()
    {
        $results = [];
        foreach ($this->getRoles() as $role) {
            $results[] = $this->dailyStatsPerTrainingsCategoryPerUserRole->run($this->date, $role);
        }
        return $results;
    }

    protected function dispatchDailyStatsPerJobRole()
    {
        $results = [];
        foreach ($this->getJobRoles() as $role) {
            $results[] = $this->dailyStatsPerJobRole->run($this->date, $role['value']);
        }
        return $results;
    }

} 