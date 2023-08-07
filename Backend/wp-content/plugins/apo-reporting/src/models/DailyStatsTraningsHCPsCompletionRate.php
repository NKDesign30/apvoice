<?php

namespace apo\reporting\models;

use awsm\wp\libraries\Model;
use apo\reporting\utilities\CreateStatsTrait;
use apo\reporting\queries\DailyStatsQuery;

class DailyStatsTraningsHCPsCompletionRate extends Model
{
    use CreateStatsTrait, DailyStatsQuery;

    protected $fillable = [
        'user_role',
        'total_users',
        'total_trainings',
        'completed_trainings',
        'date',
    ];

    protected $unique = [
        'user_role',
        'date',
    ];

	public function __construct() 
	{
        parent::__construct('apo_daily_stats_per_user_role');
    }

    public function run($date, $role)
    {
        return $this->createStats($this->getDailyStatsPerUserRole($date, $role));
    }

    public function getReportingResults($startDate, $endDate, $userRole)
    {
        return (object) array_merge(
            (array) $this->getReportingResultsFromDateRange($startDate, $endDate, $userRole),
            ['previous_data' => (array) $this->getReportingResultsBeforeDate($startDate, $userRole)],
        );
    }

    public function getReportingResultsFromDateRange($startDate, $endDate, $userRole)
    {
        $sql = $this->db->prepare("
            SELECT 
                %s as `user_role`,
                COALESCE( SUM(`{$this->table}`.`total_users`), 0) as `total_users`,
                COALESCE( SUM(`{$this->table}`.`total_trainings`), 0) as `total_trainings`,
                COALESCE( SUM(`{$this->table}`.`completed_trainings`), 0) as `completed_trainings`
            FROM `{$this->table}` 
            WHERE `{$this->table}`.`date` BETWEEN %s AND %s 
            AND `{$this->table}`.`user_role` = %s
        ", $userRole, $startDate, $endDate, $userRole);

        return $this->db->selectRow($sql);
    }

    public function getReportingResultsBeforeDate($startDate, $userRole)
    {
        $sql = $this->db->prepare("
            SELECT 
                %s as `user_role`,
                COALESCE( SUM(`{$this->table}`.`total_users`), 0) as `total_users`,
                COALESCE( SUM(`{$this->table}`.`total_trainings`), 0) as `total_trainings`,
                COALESCE( SUM(`{$this->table}`.`completed_trainings`), 0) as `completed_trainings`
            FROM `{$this->table}` 
            WHERE `{$this->table}`.`date` < %s
            AND `{$this->table}`.`user_role` = %s
        ", $userRole, $startDate, $userRole);

        return $this->db->selectRow($sql);
    }
	
}
