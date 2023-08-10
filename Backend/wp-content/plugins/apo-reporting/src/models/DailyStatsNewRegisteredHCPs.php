<?php

namespace apo\reporting\models;

use awsm\wp\libraries\Model;
use apo\reporting\utilities\CreateStatsTrait;
use apo\reporting\queries\DailyStatsQuery;

class DailyStatsNewRegisteredHCPs extends Model
{
    use CreateStatsTrait, DailyStatsQuery;

    protected $fillable = [
        'user_role',
        'total_users',
    ];

    protected $unique = [
        'user_role',
    ];

	public function __construct() 
	{
        parent::__construct('apo_daily_stats_per_user_role');
    }

    public function getReportingResults($startDate, $endDate, $userRole)
    {
        return (object) array_merge(
            (array) $this->getReportingResultsFromDateRange($startDate, $endDate, $userRole),
        );
    }

    public function getReportingResultsFromDateRange($startDate, $endDate, $userRole)
    {
        $sql = $this->db->prepare("
            SELECT 
                COALESCE( SUM(`{$this->table}`.`total_users`), 0) as `total_users`       
            FROM `{$this->table}` 
            WHERE `{$this->table}`.`date` BETWEEN %s AND %s 
            AND `{$this->table}`.`user_role` = %s
        ", $startDate, $endDate, $userRole);

        return $this->db->selectRow($sql);
    }
	
}