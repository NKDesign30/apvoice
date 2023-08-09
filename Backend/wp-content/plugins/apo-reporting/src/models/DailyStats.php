<?php

namespace apo\reporting\models;

use awsm\wp\libraries\Model;
use apo\reporting\queries\DailyStatsQuery;
use apo\reporting\utilities\CreateStatsTrait;

class DailyStats extends Model
{
    use CreateStatsTrait, DailyStatsQuery;

    protected $fillable = [
        'total_users',
        'total_trainings',
        'total_surveys',
        'total_exchanged_expert_points_into_bonago_vouchers',
        'total_redeemed_bonago_vouchers',
        'total_registered_pharmacies',
        'total_existing_pharmacies',
        'total_expert_codes',
        'total_done_key_questions',
        'total_sum_done_key_question_points',
        'total_downloads',
        'date',
    ];

    protected $unique = [
        'date',
    ];

	public function __construct() 
	{
        parent::__construct('apo_daily_stats');
    }

    public function run($date)
    {
        return $this->createStats($this->getDailyStats($date));
    }

    public function getReportingResults($startDate, $endDate)
    {
        $data = (array) $this->getReportingResultsBeforeDate($startDate);

        return (object) array_merge(
            (array) $this->getReportingResultsFromDateRange($startDate, $endDate),
            ['previous_data' => (array) $this->getReportingResultsBeforeDate($startDate)],
        );
    }

    public function getReportingResultsFromDateRange($startDate, $endDate)
    {
        $sql = $this->db->prepare("
            SELECT 
                COALESCE( SUM(`{$this->table}`.`total_users`), 0) as `total_users`,
                COALESCE( SUM(`{$this->table}`.`total_trainings`), 0) as `total_trainings`,
                COALESCE( SUM(`{$this->table}`.`total_surveys`), 0) as `total_surveys`,
                COALESCE( SUM(`{$this->table}`.`total_exchanged_expert_points_into_bonago_vouchers`), 0) as `total_exchanged_expert_points_into_bonago_vouchers`,
                COALESCE( SUM(`{$this->table}`.`total_redeemed_bonago_vouchers`), 0) as `total_redeemed_bonago_vouchers`,
                COALESCE( SUM(`{$this->table}`.`total_registered_pharmacies`), 0) as `total_registered_pharmacies`,
                COALESCE( SUM(`{$this->table}`.`total_existing_pharmacies`), 0) as `total_existing_pharmacies`,
                COALESCE( SUM(`{$this->table}`.`total_expert_codes`), 0) as `total_expert_codes`,
                COALESCE( SUM(`{$this->table}`.`total_done_key_questions`), 0) as `total_done_key_questions`,
                COALESCE( SUM(`{$this->table}`.`total_sum_done_key_question_points`), 0) as `total_sum_done_key_question_points`,
                COALESCE( MAX(`{$this->table}`.`total_downloads`), 0) as `total_downloads`
            FROM `{$this->table}` 
            WHERE `{$this->table}`.`date` BETWEEN %s AND %s
        ", $startDate, $endDate);

        return $this->db->selectRow($sql);
    }

    public function getReportingResultsBeforeDate($startDate)
    {
        $sql = $this->db->prepare("
            SELECT 
                COALESCE( SUM(`{$this->table}`.`total_users`), 0) as `total_users`,
                COALESCE( SUM(`{$this->table}`.`total_trainings`), 0) as `total_trainings`,
                COALESCE( SUM(`{$this->table}`.`total_surveys`), 0) as `total_surveys`,
                COALESCE( SUM(`{$this->table}`.`total_exchanged_expert_points_into_bonago_vouchers`), 0) as `total_exchanged_expert_points_into_bonago_vouchers`,
                COALESCE( SUM(`{$this->table}`.`total_redeemed_bonago_vouchers`), 0) as `total_redeemed_bonago_vouchers`,
                COALESCE( SUM(`{$this->table}`.`total_registered_pharmacies`), 0) as `total_registered_pharmacies`,
                COALESCE( SUM(`{$this->table}`.`total_existing_pharmacies`), 0) as `total_existing_pharmacies`,
                COALESCE( SUM(`{$this->table}`.`total_expert_codes`), 0) as `total_expert_codes`,
                COALESCE( SUM(`{$this->table}`.`total_done_key_questions`), 0) as `total_done_key_questions`,
                COALESCE( SUM(`{$this->table}`.`total_sum_done_key_question_points`), 0) as `total_sum_done_key_question_points`,
                COALESCE( MAX(`{$this->table}`.`total_downloads`), 0) as `total_downloads`
            FROM `{$this->table}` 
            WHERE `{$this->table}`.`date` < %s
        ", $startDate);

        return $this->db->selectRow($sql);
    }
	
}
