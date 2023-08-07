<?php

namespace apo\reporting\models;

use awsm\wp\libraries\Model;
use apo\reporting\utilities\CreateStatsTrait;
use apo\reporting\queries\DailyStatsQuery;

class DailyStatsPerSurvey extends Model 
{
    use CreateStatsTrait, DailyStatsQuery;

    protected $fillable = [
        'survey_id',
        'survey_title',
        'total_done',
        'date',
    ];

    protected $unique = [
        'survey_id',
        'date',
    ];

	public function __construct() 
	{
        parent::__construct('apo_daily_stats_per_survey');
    }

    public function run($date)
    {
        foreach ($this->getDailyStatsPerSurvey($date) as $stats) {
            $result[] = $this->createStats($stats);
        }
        return $result;
    }

    public function getReportingResults($startDate, $endDate)
    {
        $sql = $this->db->prepare("
            SELECT
                `{$this->table}`.`survey_title`,
                COALESCE( SUM(`{$this->table}`.`total_done`), 0) as `total_done`
            FROM `{$this->table}`
            WHERE 
                `{$this->table}`.`date` BETWEEN %s AND %s
            GROUP BY
                `{$this->table}`.`survey_id`
        ", $startDate, $endDate);

        return $this->db->select($sql);
    }

    public function showOrderByDesc()
    {
        return $this->db->select('SELECT * FROM ' . $this->table . ' ORDER BY date DESC');
    }
	
}
