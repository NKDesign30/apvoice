<?php 

namespace apo\reporting\queries;

trait TotalRegisteredPharmaciesQuery
{

    public function getTotalRegisteredPharmaciesForSpecificPeriod($startDate, $endDate, $granularity = null)
    {
        $sql = $this->db->prepare("
            SELECT
                COALESCE( SUM(`{$this->prefix}apo_daily_stats`.`total_registered_pharmacies`), 0 ) as `total_registered_pharmacies`,
                %s as `start_date`,
                %s as `end_date`,
                %s as `granularity`
            FROM `{$this->prefix}apo_daily_stats`
            WHERE `{$this->prefix}apo_daily_stats`.`date` BETWEEN %s AND  %s 
        ", $startDate, $endDate, $granularity, $startDate, $endDate);

        return $this->db->selectRow($sql);
    }

    public function getTotalRegisteredPharmaciesPerSalesRepForSpecificPeriod($startDate, $endDate, $granularity = null)
    {
        $sql = $this->db->prepare("
            SELECT
                `{$this->prefix}apo_daily_stats_per_sales_rep`.`sales_rep_user_id`,
                COUNT( DISTINCT `{$this->prefix}apo_daily_stats_per_sales_rep`.`registered_pharmacy_id` ) as `total_registered_pharmacies`,
                %s as `start_date`,
                %s as `end_date`,
                %s as `granularity`
            FROM `{$this->prefix}apo_daily_stats_per_sales_rep`
            WHERE `{$this->prefix}apo_daily_stats_per_sales_rep`.`date` BETWEEN %s AND  %s 
            GROUP BY `{$this->prefix}apo_daily_stats_per_sales_rep`.`sales_rep_user_id`
        ", $startDate, $endDate, $granularity, $startDate, $endDate);

        return $this->db->select($sql);
    }

}