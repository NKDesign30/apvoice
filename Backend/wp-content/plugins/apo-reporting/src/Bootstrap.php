<?php

namespace apo\reporting;

use awsm\wp\libraries\DB;
use awsm\wp\libraries\utilities\DatabaseUtils;
use awsm\wp\libraries\utilities\Migratable;
use awsm\wp\libraries\interfaces\CreateSchemasInterface;
use apo\reporting\jobs\types\Granularity;

class Bootstrap implements CreateSchemasInterface {

    use DatabaseUtils, Migratable;

    protected $db;
    protected $networkWide;
	protected $schemas;
	protected $primaryBlogSchemas;
    
    public function __construct($networkWide = true) 
    {
        $this->db = DB::instance();
        $this->schemas = [];
        $this->primaryBlogSchemas = [];
        $this->networkWide = $networkWide;
        return $this;
    }

    public function createSchemas()
    {
        $this->createDailyStatsSchema()
            ->createDailyStatsPerUserRoleSchema()
            ->createDailyStatsPerSalesRepSchema()
            ->createDailyStatsPerTrainingsCategorySchema()
            ->createDailyStatsPerTrainingsCategoryPerUserRoleSchema()
            ->createReportingKpiTotalTrainingsPerUserRoleSchema()
            ->createReportingKpiTotalSurveysPerUserRoleSchema()
            ->createReportingKpiTotalBonagoVouchersPerUserRoleSchema()
            ->createReportingKpiTotalUsersPerUserRoleSchema()
            ->createReportingKpiTotalRegisteredPharmaciesSchema()
            ->createReportingKpiTotalRegisteredPharmaciesPerSalesRepSchema();

        return $this;
    }

    public function createPrimaryBlogSchemas() 
    {
        $this->createGranularitySchema()
            ->seedGranularitiesTable();

        return $this;
    }

    protected function createDailyStatsSchema()
    {
        $tableName = $this->createTableName('apo_daily_stats');

        $table = "CREATE TABLE `{$tableName}` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `total_users` int(10) unsigned DEFAULT NULL,
            `total_trainings` int(10) unsigned DEFAULT NULL,
            `total_surveys` int(10) unsigned DEFAULT NULL,
            `total_exchanged_expert_points_into_bonago_vouchers` int(10) unsigned DEFAULT NULL,
            `total_redeemed_bonago_vouchers` int(10) unsigned DEFAULT NULL,
            `total_registered_pharmacies` int(10) unsigned DEFAULT NULL,
            `total_existing_pharmacies` int(10) unsigned DEFAULT NULL,
            `total_expert_codes` int(10) unsigned DEFAULT NULL,
            `total_done_key_questions` int(10) unsigned DEFAULT NULL,
            `total_sum_done_key_question_points` int(10) unsigned DEFAULT NULL,
            `total_downloads` int(10) NOT NULL,
            `date` date DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE (`date`)
        )" . $this->db->wpdb->get_charset_collate();
        
        $this->addSchema($table);
        return $this;
    }

    protected function createDailyStatsPerUserRoleSchema()
    {
        $tableName = $this->createTableName('apo_daily_stats_per_user_role');

        $table = "CREATE TABLE `{$tableName}` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `user_role` varchar(255) NOT NULL DEFAULT '',
            `total_users` int(10) unsigned DEFAULT NULL,
            `total_trainings` int(10) unsigned DEFAULT NULL,
            `completed_trainings` int(10) unsigned DEFAULT NULL,
            `total_surveys` int(10) unsigned DEFAULT NULL,
            `completed_surveys` int(10) unsigned DEFAULT NULL,
            `total_exchanged_expert_points_into_bonago_vouchers` int(10) unsigned DEFAULT NULL,
            `total_redeemed_bonago_vouchers` int(10) unsigned DEFAULT NULL,
            `total_done_key_questions` int(10) unsigned DEFAULT NULL,
            `total_sum_done_key_question_points` int(10) unsigned DEFAULT NULL,
            `date` date DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `user_role_date` (`user_role`, `date`)
        )" . $this->db->wpdb->get_charset_collate();

        $this->addSchema($table);
        return $this;
    }

    protected function createDailyStatsPerSalesRepSchema()
    {
        $tableName = $this->createTableName('apo_daily_stats_per_sales_rep');

        $table = "CREATE TABLE `{$tableName}` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `sales_rep_user_id` int(11) unsigned DEFAULT NULL,
            `user_id` int(11) DEFAULT NULL,
            `registered_expert_code` varchar(255) DEFAULT NULL,
            `registered_pharmacy_id` int(11) unsigned DEFAULT NULL,
            `pharmacy_unique_number` varchar(255) DEFAULT NULL,
            `pharmacy_name` varchar(255) DEFAULT NULL,
            `date` date DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `sales_rep_user_id_user_id_date` (`sales_rep_user_id`, `user_id`, `date`)
        )" . $this->db->wpdb->get_charset_collate();

        $this->addSchema($table);
        return $this;
    }

    protected function createDailyStatsPerTrainingsCategorySchema()
    {
        $tableName = $this->createTableName('apo_daily_stats_per_trainings_category');

        $table = "CREATE TABLE `{$tableName}` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `category_name` varchar(255) DEFAULT NULL,
            `total_trainings_per_category` int(10) unsigned DEFAULT NULL,
            `total_done_key_questions` int(10) unsigned DEFAULT NULL,
            `total_sum_done_key_question_points` int(10) unsigned DEFAULT NULL,
            `date` date DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `category_name_date` (`category_name`, `date`)
        )" . $this->db->wpdb->get_charset_collate();

        $this->addSchema($table);
        return $this;
    }

    protected function createDailyStatsPerJobRoleSchema()
    {
        $tableName = $this->createTableName('apo_daily_stats_per_job_role');
        
        $table = "CREATE TABLE `{$tableName}` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `job_role` varchar(255) DEFAULT NULL,
            `total_users` int(11) DEFAULT NULL,
            `date` date DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `job_role_date` (`job_role`, `date`)
        )" . $this->db->wpdb->get_charset_collate();

        $this->addSchema($table);
        return $this;
    }

    protected function createDailyStatsPerDownloadSchema()
    {
        $tableName = $this->createTableName('apo_daily_stats_per_download');

        $table = "CREATE TABLE `{$tableName}` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `download_id` int(11) DEFAULT NULL,
            `download_title` varchar(255) DEFAULT NULL,
            `product_title` varchar(255) DEFAULT NULL,
            `download_mediatype` varchar(255) DEFAULT NULL,
            `total_downloads` int(11) DEFAULT NULL,
            `date` date DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `download_id_date` (`download_id`, `date`)
        )" . $this->db->wpdb->get_charset_collate();

        $this->addSchema($table);
        return $this;
    }

    protected function createDailyStatsPerTrainingsCategoryPerUserRoleSchema()
    {
        $tableName = $this->createTableName('apo_daily_stats_per_trainings_category_per_user_role');

        $table = "CREATE TABLE `{$tableName}` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `category_name` varchar(255) DEFAULT NULL,
            `user_role` varchar(255) DEFAULT NULL,
            `total_trainings_per_category` int(10) unsigned DEFAULT NULL,
            `total_completed_trainings_per_category` int(10) unsigned DEFAULT NULL,
            `total_done_key_questions` int(10) unsigned DEFAULT NULL,
            `total_sum_done_key_question_points` int(10) unsigned DEFAULT NULL,
            `date` date DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `category_name_user_role_date` (`category_name`, `user_role`, `date`)
        )" . $this->db->wpdb->get_charset_collate();

        $this->addSchema($table);
        return $this;
    }

    protected function createReportingKpiTotalTrainingsPerUserRoleSchema()
    {
        $tableName = $this->createTableName('apo_reporting_kpi_trainings_per_user_role');

        $table = "CREATE TABLE `{$tableName}` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `user_role` varchar(255) NOT NULL DEFAULT '',
            `total_trainings` int(10) unsigned DEFAULT NULL,
            `completed_trainings` int(10) unsigned DEFAULT NULL,
            `start_date` date DEFAULT NULL,
            `end_date` date DEFAULT NULL,
            `granularity` tinyint(2) unsigned DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `user_role_start_date_end_date_granularity` (`user_role`, `start_date`, `end_date`, `granularity`)
        )" . $this->db->wpdb->get_charset_collate();

        $this->addSchema($table);
        return $this;
    }

    protected function createReportingKpiTotalSurveysPerUserRoleSchema()
    {
        $tableName = $this->createTableName('apo_reporting_kpi_surveys_per_user_role');

        $table = "CREATE TABLE `{$tableName}` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `user_role` varchar(255) NOT NULL DEFAULT '',
            `total_surveys` int(10) unsigned DEFAULT NULL,
            `completed_surveys` int(10) unsigned DEFAULT NULL,
            `start_date` date DEFAULT NULL,
            `end_date` date DEFAULT NULL,
            `granularity` tinyint(2) unsigned DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `user_role_start_date_end_date_granularity` (`user_role`, `start_date`, `end_date`, `granularity`)
        )" . $this->db->wpdb->get_charset_collate();

        $this->addSchema($table);
        return $this;
    }

    protected function createReportingKpiTotalBonagoVouchersPerUserRoleSchema()
    {
        $tableName = $this->createTableName('apo_reporting_kpi_total_bonago_vouchers_per_user_role');

        $table = "CREATE TABLE `{$tableName}` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `user_role` varchar(255) NOT NULL DEFAULT '',
            `total_exchanged_expert_points_into_bonago_vouchers` int(10) unsigned DEFAULT NULL,
            `total_redeemed_bonago_vouchers` int(10) unsigned DEFAULT NULL,
            `start_date` date DEFAULT NULL,
            `end_date` date DEFAULT NULL,
            `granularity` tinyint(2) unsigned DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `user_role_start_date_end_date_granularity` (`user_role`, `start_date`, `end_date`, `granularity`)
        )" . $this->db->wpdb->get_charset_collate();

        $this->addSchema($table);
        return $this;
    }

    protected function createReportingKpiTotalUsersPerUserRoleSchema()
    {
        $tableName = $this->createTableName('apo_reporting_kpi_total_users_per_user_role');

        $table = "CREATE TABLE `{$tableName}` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `user_role` varchar(255) NOT NULL DEFAULT '',
            `total_users` int(10) unsigned DEFAULT NULL,
            `start_date` date DEFAULT NULL,
            `end_date` date DEFAULT NULL,
            `granularity` tinyint(2) unsigned DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `user_role_end_date_granularity` (`user_role`, `start_date`, `end_date`, `granularity`)
        )" . $this->db->wpdb->get_charset_collate();

        $this->addSchema($table);
        return $this;
    }

    protected function createReportingKpiTotalRegisteredPharmaciesSchema()
    {
        $tableName = $this->createTableName('apo_reporting_kpi_total_registered_pharmacies');

        $table = "CREATE TABLE `{$tableName}` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `total_registered_pharmacies` int(10) unsigned DEFAULT NULL,
            `start_date` date DEFAULT NULL,
            `end_date` date DEFAULT NULL,
            `granularity` tinyint(2) unsigned DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `start_date_end_date_granularity` (`start_date`, `end_date`, `granularity`)
        )" . $this->db->wpdb->get_charset_collate();

        $this->addSchema($table);
        return $this;
    }

    protected function createReportingKpiTotalRegisteredPharmaciesPerSalesRepSchema()
    {
        $tableName = $this->createTableName('apo_reporting_kpi_total_registered_pharmacies_per_sales_rep');

        $table = "CREATE TABLE `{$tableName}` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `sales_rep_user_id` int(11) unsigned NOT NULL,
            `total_registered_pharmacies` int(10) unsigned DEFAULT NULL,
            `start_date` date DEFAULT NULL,
            `end_date` date DEFAULT NULL,
            `granularity` tinyint(2) unsigned DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `sales_rep_user_id_start_date_end_date_granularity` (`sales_rep_user_id`, `start_date`, `end_date`, `granularity`)
        )" . $this->db->wpdb->get_charset_collate();

        $this->addSchema($table);
        return $this;
    }

    protected function createGranularitySchema()
    {
        $tableName = $this->createTableName('apo_granularity_lookup');

        $table = "CREATE TABLE `{$tableName}` (
            `id` int(11) unsigned NOT NULL,
            `name` varchar(255) NOT NULL DEFAULT '',
            PRIMARY KEY (`id`),
            UNIQUE KEY `name` (`name`)
        )" . $this->db->wpdb->get_charset_collate();

        $this->addPrimaryBlogSchema($table);
        return $this;
    }

    protected function seedGranularitiesTable()
    {
        $tableName = $this->createTableName('apo_granularity_lookup');

        $day = Granularity::DAILY;
        $week = Granularity::WEEKLY;
        $month = Granularity::MONTHLY;
        $quarter = Granularity::QUARTERLY;
        $year = Granularity::YEARLY;
        $yearToDate = Granularity::YEAR_TO_DATE;
        $custom = Granularity::CUSTOM;

        $sql = "INSERT INTO `{$tableName}`
            (`id`, `name`)
            VALUES
            ({$day}, 'Day'),
            ({$week}, 'Week'),
            ({$month}, 'Month'),
            ({$quarter}, 'Quarter'),
            ({$year}, 'Year'),
            ({$yearToDate}, 'Year-to-Date'),
            ({$custom}, 'Custom');
        ";

        $this->addPrimaryBlogSchema($sql);
        return $this;
    }

    public function down()
    {   
        return $this;
    }

}
