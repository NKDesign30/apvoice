<?php 

namespace apo\reporting\queries;

trait TotalTrainingsPerUserRoleQuery
{

    public function getTotalTrainingsPerUserRoleForSpecificPeriod($startDate, $endDate, $role, $granularity = null)
    {
        $sql = $this->db->prepare("
            SELECT
                %s as `user_role`,
                COALESCE( SUM(`{$this->prefix}apo_daily_stats_per_user_role`.`total_trainings`), 0 ) as `total_trainings`,
                COALESCE( SUM(`{$this->prefix}apo_daily_stats_per_user_role`.`completed_trainings`), 0 ) as `completed_trainings`,
                %s as `start_date`,
                %s as `end_date`,
                %s as `granularity`
            FROM `{$this->prefix}apo_daily_stats_per_user_role`
            WHERE `{$this->prefix}apo_daily_stats_per_user_role`.`user_role` = %s
            AND `{$this->prefix}apo_daily_stats_per_user_role`.`date` BETWEEN %s AND  %s 
        ", $role, $startDate, $endDate, $granularity, $role, $startDate, $endDate);

        return $this->db->selectRow($sql);
    }

}