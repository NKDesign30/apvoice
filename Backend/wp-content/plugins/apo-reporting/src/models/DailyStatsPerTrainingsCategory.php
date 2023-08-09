<?php

namespace apo\reporting\models;

use awsm\wp\libraries\Model;
use apo\reporting\utilities\CreateStatsTrait;
use apo\reporting\queries\DailyStatsQuery;;

class DailyStatsPerTrainingsCategory extends Model 
{
    use CreateStatsTrait, DailyStatsQuery;

    protected $fillable = [
        'category_name',
        'total_trainings_per_category',
        'total_done_key_questions',
        'total_sum_done_key_question_points',
        'date',
    ];

    protected $unique = [
        'category_name',
        'date',
    ];

	public function __construct() 
	{
        parent::__construct('apo_daily_stats_per_trainings_category');
    }

    public function run($date)
    {
        $result = [];
        foreach ($this->getDailyStatsPerTrainingCategory($date) as $stats) {
            $result[] = $this->createStats($stats);
        }
        return $result;
    }

    public function getReportingResults($startDate, $endDate)
    {
        $sql = $this->db->prepare("
            SELECT
                COALESCE( SUM(`{$this->table}`.`total_trainings_per_category`), 0 ) as `total_trainings_per_category`,
                `{$this->table}`.`category_name` as `category_name`, 
                `{$this->table}`.`total_done_key_questions` as `total_done_key_questions`, 
                `{$this->table}`.`total_sum_done_key_question_points` as `total_sum_done_key_question_points`
            FROM `{$this->table}`
            WHERE 
                `{$this->table}`.`date` BETWEEN %s AND %s
            GROUP BY `{$this->table}`.`category_name`
        ", $startDate, $endDate);

        return $this->db->select($sql);
    }
}
