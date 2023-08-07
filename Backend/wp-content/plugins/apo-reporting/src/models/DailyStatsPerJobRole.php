<?php

namespace apo\reporting\models;

use awsm\wp\libraries\Model;
use apo\reporting\utilities\CreateStatsTrait;
use apo\reporting\queries\DailyStatsQuery;

class DailyStatsPerJobRole extends Model 
{
    use CreateStatsTrait, DailyStatsQuery;

    protected $fillable = [
        'job_role',
        'total_users',
        'date',
    ];

    protected $unique = [
        'job_role',
        'date',
    ];

	public function __construct() 
	{
        parent::__construct('apo_daily_stats_per_job_role');
    }

    public function run($date, $role)
    {
        return $this->createStats($this->getDailyStatsPerJobRole($date, $role));
    }

    public function getReportingResults($startDate, $endDate, $jobRole)
    {
        $sql = $this->db->prepare("
            SELECT
                %s as `job_role`,
                COALESCE( MAX(`{$this->table}`.`total_users`), 0) as `total_users`
            FROM `{$this->table}`
            WHERE 
                `{$this->table}`.`date` BETWEEN %s AND %s
                AND `{$this->table}`.`job_role` = %s
        ", $jobRole, $startDate, $endDate, $jobRole);

        $period = $this->db->selectRow($sql);

        $sql = $this->db->prepare("
            SELECT
                %s as `job_role`,
                COALESCE( MAX(`{$this->table}`.`total_users`), 0) as `total_users`
            FROM `{$this->table}`
            WHERE 
                `{$this->table}`.`date` < %s
                AND `{$this->table}`.`job_role` = %s
        ", $jobRole, $startDate, $jobRole);

        $prev = $this->db->selectRow($sql);
        return (object) array_merge(
            (array) $period,
            ['previous_data' => (array) $prev],
        );
    }

    public function showOrderByDesc()
    {
        return $this->db->select('SELECT * FROM ' . $this->table . ' ORDER BY date DESC');
    }
	
}
