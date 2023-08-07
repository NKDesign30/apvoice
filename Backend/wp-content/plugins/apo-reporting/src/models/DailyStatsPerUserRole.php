<?php

namespace apo\reporting\models;

use awsm\wp\libraries\Model;
use apo\reporting\utilities\CreateStatsTrait;
use apo\reporting\queries\DailyStatsQuery;

class DailyStatsPerUserRole extends Model 
{
    use CreateStatsTrait, DailyStatsQuery;

    protected $fillable = [
        'user_role',
        'total_users',
        'total_trainings',
        'completed_trainings',
        'participated_trainings',
        'total_surveys',
        'completed_surveys',
        'total_exchanged_expert_points_into_bonago_vouchers',
        'total_redeemed_bonago_vouchers',
        'total_done_key_questions',
        'total_sum_done_key_question_points',
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
                COALESCE( SUM(`{$this->table}`.`completed_trainings`), 0) as `completed_trainings`,
                COALESCE( SUM(`{$this->table}`.`participated_trainings`), 0) as `participated_trainings`,
                COALESCE( SUM(`{$this->table}`.`total_surveys`), 0) as `total_surveys`,
                COALESCE( SUM(`{$this->table}`.`completed_surveys`), 0) as `completed_surveys`,
                COALESCE( SUM(`{$this->table}`.`total_exchanged_expert_points_into_bonago_vouchers`), 0) as `total_exchanged_expert_points_into_bonago_vouchers`,
                COALESCE( SUM(`{$this->table}`.`total_redeemed_bonago_vouchers`), 0) as `total_redeemed_bonago_vouchers`,
                COALESCE( SUM(`{$this->table}`.`total_done_key_questions`), 0) as `total_done_key_questions`,
                COALESCE( SUM(`{$this->table}`.`total_sum_done_key_question_points`), 0) as `total_sum_done_key_question_points`
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
                COALESCE( SUM(`{$this->table}`.`completed_trainings`), 0) as `completed_trainings`,
                COALESCE( SUM(`{$this->table}`.`participated_trainings`), 0) as `participated_trainings`,
                COALESCE( SUM(`{$this->table}`.`total_surveys`), 0) as `total_surveys`,
                COALESCE( SUM(`{$this->table}`.`completed_surveys`), 0) as `completed_surveys`,
                COALESCE( SUM(`{$this->table}`.`total_exchanged_expert_points_into_bonago_vouchers`), 0) as `total_exchanged_expert_points_into_bonago_vouchers`,
                COALESCE( SUM(`{$this->table}`.`total_redeemed_bonago_vouchers`), 0) as `total_redeemed_bonago_vouchers`,
                COALESCE( SUM(`{$this->table}`.`total_done_key_questions`), 0) as `total_done_key_questions`,
                COALESCE( SUM(`{$this->table}`.`total_sum_done_key_question_points`), 0) as `total_sum_done_key_question_points`
            FROM `{$this->table}` 
            WHERE `{$this->table}`.`date` < %s
            AND `{$this->table}`.`user_role` = %s
        ", $userRole, $startDate, $userRole);

        return $this->db->selectRow($sql);
    }
	
}
