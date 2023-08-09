<?php

namespace apo\reporting\models;

use awsm\wp\libraries\Model;
use apo\reporting\utilities\CreateStatsTrait;
use apo\reporting\queries\DailyStatsQuery;

class DailyStatsPerTrainingsCategoryPerUserRole extends Model 
{
    use CreateStatsTrait, DailyStatsQuery;

    protected $fillable = [
        'category_name',
        'user_role',
        'total_trainings_per_category',
        'total_completed_trainings_per_category',
        'total_done_key_questions',
        'total_sum_done_key_question_points',
        'date',
    ];

    protected $unique = [
        'category_name',
        'user_role',
        'date',
    ];

	public function __construct() 
	{
        parent::__construct('apo_daily_stats_per_trainings_category_per_user_role');
    }

    public function run($date, $role)
    {
        $result = [];
        foreach ($this->getDailyStatsPerTrainingCategoryPerUserRole($date, $role) as $stats) {
            $result[] = $this->createStats($stats);
        }
        return $result;
    }

    public function getReportingResults($startDate, $endDate, $userRole)
    { 
        $sql = $this->db->prepare("
            SELECT
                `{$this->table}`.`user_role` as `user_role`,
                COALESCE( SUM(`{$this->table}`.`total_trainings_per_category`), 0) as `total_trainings_per_category`,
                COALESCE( SUM( `{$this->table}`.`total_completed_trainings_per_category`), 0) as `total_completed_trainings_per_category`,
                `{$this->table}`.`category_name` as `category_name`,
                `{$this->table}`.`total_done_key_questions` as `total_done_key_questions`,
                `{$this->table}`.`total_sum_done_key_question_points` as `total_sum_done_key_question_points`
            FROM `{$this->table}`
            WHERE 
                `{$this->table}`.`date` BETWEEN %s AND %s
                AND `{$this->table}`.`user_role` = %s
            GROUP BY `{$this->table}`.`user_role`, `{$this->table}`.`category_name`
        ", $startDate, $endDate, $userRole);

        return $this->db->select($sql);
    }
	
}
