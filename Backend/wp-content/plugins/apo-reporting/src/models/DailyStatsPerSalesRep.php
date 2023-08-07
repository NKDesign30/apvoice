<?php

namespace apo\reporting\models;

use awsm\wp\libraries\Model;
use apo\reporting\utilities\CreateStatsTrait;
use apo\reporting\queries\DailyStatsQuery;

class DailyStatsPerSalesRep extends Model 
{
    use CreateStatsTrait, DailyStatsQuery;

    protected $fillable = [
        'sales_rep_user_id',
        'user_id',
        'registered_expert_code',
        'registered_pharmacy_id',
        'pharmacy_unique_number',
        'pharmacy_name',
        'date',
    ];

    protected $unique = [
        'sales_rep_user_id',
        'user_id',
        'date',
    ];

	public function __construct() 
	{
        parent::__construct('apo_daily_stats_per_sales_rep');
    }

    public function run($date)
    {
        $result = [];
        foreach ($this->getDailyStatsPerSalesRep($date) as $stats) {
            $result[] = $this->createStats($stats);
        }
        return $result;
    }

    public function getReportingResults($startDate, $endDate)
    {
        $sql = $this->db->prepare("
            SELECT
                `{$this->table}`.`sales_rep_user_id` as `sales_rep_user_id`,
                COUNT(DISTINCT `{$this->table}`.`registered_pharmacy_id`) as `registered_pharmacies`
            FROM `{$this->table}`
            WHERE 
                `{$this->table}`.`date` BETWEEN %s AND %s
            GROUP BY `{$this->table}`.`sales_rep_user_id`
        ", $startDate, $endDate);

        return $this->db->select($sql);
    }

    public function showOrderByDesc()
    {
        return $this->db->select('SELECT * FROM ' . $this->table . ' ORDER BY date DESC');
    }
	
}
