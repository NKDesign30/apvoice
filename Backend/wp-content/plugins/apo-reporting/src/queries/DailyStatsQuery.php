<?php 
namespace apo\reporting\queries;

trait DailyStatsQuery 
{
    public function getDailyStats($date) 
    {
        $blogId = get_current_blog_id();

        $sql = $this->db->prepare("
            SELECT (
                SELECT 
                    COUNT(`{$this->defaultPrefix}users`.`ID`) as `total_users`
                FROM `{$this->defaultPrefix}users`
                LEFT JOIN
                    `{$this->defaultPrefix}usermeta` ON `{$this->defaultPrefix}users`.`ID` = `{$this->defaultPrefix}usermeta`.`user_id`
                WHERE 
                    CAST(`{$this->defaultPrefix}users`.`user_registered` as DATE) = %s AND 
                    `{$this->defaultPrefix}usermeta`.`meta_key` = 'primary_blog' AND 
                    `{$this->defaultPrefix}usermeta`.`meta_value` = %s
                GROUP BY 
                    CAST(`{$this->defaultPrefix}users`.`user_registered` as DATE)
            ) as `total_users`,
            (
                SELECT 
                    COUNT(`{$this->prefix}posts`.`ID`) as `total_trainings`
                FROM `{$this->prefix}posts`
                WHERE 
                    `{$this->prefix}posts`.`post_type` = 'trainings' AND 
                    `{$this->prefix}posts`.`post_status` = 'publish' AND 
                    CAST(`{$this->prefix}posts`.`post_date` as DATE) = %s
                GROUP BY 
                    CAST(`{$this->prefix}posts`.`post_date` as DATE)
            ) as `total_trainings`,
            (
                SELECT 
                    COUNT(`{$this->prefix}posts`.`ID`) as `total_surveys`
                FROM `{$this->prefix}posts`
                WHERE 
                    `{$this->prefix}posts`.`post_type` = 'surveys' AND 
                    `{$this->prefix}posts`.`post_status` = 'publish' AND 
                    CAST(`{$this->prefix}posts`.`post_date` as DATE) = %s
                GROUP BY 
                    CAST(`{$this->prefix}posts`.`post_date` as DATE)
            ) as `total_surveys`,
            (
                SELECT 
                    COUNT(`{$this->prefix}expert_points`.`id`) as `total_exchanged_expert_points_into_bonago_vouchers`
                FROM `{$this->prefix}expert_points`
                WHERE 
                    `{$this->prefix}expert_points`.`related_type` = 'bonago' AND 
                    CAST(`{$this->prefix}expert_points`.`created_at` as DATE) = %s
                GROUP BY 
                    CAST(`{$this->prefix}expert_points`.`created_at` as DATE)
            ) as `total_exchanged_expert_points_into_bonago_vouchers`,
            (
                SELECT 
                    COUNT(`{$this->prefix}bonago_voucher_codes`.`id`) as `total_redeemed_bonago_vouchers`
                FROM `{$this->prefix}bonago_voucher_codes`
                WHERE 
                    `{$this->prefix}bonago_voucher_codes`.`redeemed` = 1 AND 
                    CAST(`{$this->prefix}bonago_voucher_codes`.`redeemed_at` as DATE) = %s
                GROUP BY 
                    CAST(`{$this->prefix}bonago_voucher_codes`.`redeemed_at` as DATE)
            ) as `total_redeemed_bonago_vouchers`,
            (
                SElECT 
                    COUNT(DISTINCT `{$this->prefix}apovoice_pharmacy_user`.`pharmacy_id`) as `total_registered_pharmacies`
                FROM `{$this->prefix}apovoice_pharmacy_user`
                WHERE 
                    CAST(`{$this->prefix}apovoice_pharmacy_user`.`created_at` as DATE) = %s
                GROUP BY 
                    CAST(`{$this->prefix}apovoice_pharmacy_user`.`created_at` as DATE)
            ) as `total_registered_pharmacies`,
            (
                SElECT 
                    COUNT(`{$this->prefix}apovoice_pharmacies`.`id`) as `total_existing_pharmacies`
                FROM `{$this->prefix}apovoice_pharmacies`
                WHERE 
                    CAST(`{$this->prefix}apovoice_pharmacies`.`created_at` as DATE) = %s
                GROUP BY 
                    CAST(`{$this->prefix}apovoice_pharmacies`.`created_at` as DATE)
            ) as `total_existing_pharmacies`,
            (
                SELECT 
                    COUNT(DISTINCT `{$this->prefix}expert_codes`.`expert_code`) as `expert_code`
                FROM `{$this->prefix}expert_codes`
                WHERE 
                    CAST(`{$this->prefix}expert_codes`.`created_at` as DATE) = %s 
                GROUP BY 
                   CAST(`{$this->prefix}expert_codes`.`created_at` as DATE)
            ) as `total_expert_codes`,
            (
                SELECT 
                    SUM(`{$this->prefix}postmeta`.meta_value) 
                FROM `{$this->prefix}postmeta`
                LEFT JOIN `{$this->prefix}posts` ON `{$this->prefix}posts`.`ID` = `{$this->prefix}postmeta`.`post_id`
                WHERE
                    `{$this->prefix}posts`.`post_type` = 'downloads' AND 
                    `{$this->prefix}posts`.`post_status` = 'publish' AND
                    `{$this->prefix}postmeta`.`meta_key` = 'downloads'
            ) as `total_downloads`,
            %s as `date`
        ", $date, $blogId, $date, $date, $date, $date, $date, $date, $date, $date);

        $firstResult = $this->db->selectRow($sql);

        return (object) array_merge( (array) $firstResult, (array) $this->getDailyStatsForRatingKeyQuestionsAverage($date) );
    }

    public function getDailyStatsPerUserRole($date, $role)
    {
        $blogId = get_current_blog_id();
        
        $escapedRole = '%' . $this->db->wpdb->esc_like($role) . '%';

        $sql = $this->db->prepare("
            SELECT (
                SELECT 
                    COUNT(`{$this->defaultPrefix}users`.`ID`) as `total_users`
                FROM `{$this->defaultPrefix}users`
                LEFT JOIN
                    `{$this->defaultPrefix}usermeta` ON `{$this->defaultPrefix}users`.`ID` = `{$this->defaultPrefix}usermeta`.`user_id`
                LEFT JOIN
                    `wp_usermeta` as `wp_um1` ON `wp_users`.`ID` = `wp_um1`.`user_id`
                WHERE 
                CAST(`{$this->defaultPrefix}users`.`user_registered` as DATE) = %s AND 
                    ( `{$this->defaultPrefix}usermeta`.`meta_key` = '{$this->prefix}capabilities' AND 
                    `{$this->defaultPrefix}usermeta`.`meta_value` LIKE %s ) AND
                    ( `wp_um1`.`meta_key` = 'primary_blog' AND 
                    `wp_um1`.`meta_value` = %s) 
                GROUP BY 
                    CAST(`{$this->defaultPrefix}users`.`user_registered` as DATE)
            ) as `total_users`,
            (
                SELECT 
                    COUNT(`{$this->prefix}posts`.`ID`) as `total_trainings`
                FROM `{$this->prefix}posts`
                LEFT JOIN `{$this->prefix}postmeta` ON `{$this->prefix}posts`.`ID` = `{$this->prefix}postmeta`.`post_id`
                WHERE 
                    `{$this->prefix}posts`.`post_type` = 'trainings' AND 
                    `{$this->prefix}posts`.`post_status` = 'publish' AND 
                    `{$this->prefix}postmeta`.`meta_key` = 'apo_user_access_permissions' AND 
                    ( `{$this->prefix}postmeta`.`meta_value` LIKE %s OR `{$this->prefix}postmeta`.`meta_value` LIKE '%no_restriction%' ) 
                    AND CAST(`{$this->prefix}posts`.`post_date` as DATE) = %s
                GROUP BY 
                    CAST(`{$this->prefix}posts`.`post_date` as DATE)
            ) as `total_trainings`,
            (
                SELECT
                    COUNT(`{$this->prefix}training_user_results`.`id`) as `completed_trainings`
                FROM `{$this->prefix}training_user_results`
                LEFT JOIN `{$this->prefix}postmeta` ON `{$this->prefix}training_user_results`.`training_id` = `{$this->prefix}postmeta`.`post_id`
                LEFT JOIN `{$this->defaultPrefix}usermeta` ON `{$this->prefix}training_user_results`.`user_id` = `{$this->defaultPrefix}usermeta`.`user_id`
                WHERE
                    CAST(`{$this->prefix}training_user_results`.`created_at` as DATE) = %s AND
                    `{$this->prefix}postmeta`.`meta_key` = 'apo_user_access_permissions' AND 
                    ( `{$this->prefix}postmeta`.`meta_value` LIKE %s OR `{$this->prefix}postmeta`.`meta_value` LIKE '%no_restriction%' ) AND  
                    `{$this->prefix}training_user_results`.`is_complete` = 1 AND
                    ( `{$this->defaultPrefix}usermeta`.`meta_key` = '{$this->prefix}capabilities' AND `{$this->defaultPrefix}usermeta`.`meta_value` LIKE %s) 
                GROUP BY 
                    CAST(`{$this->prefix}training_user_results`.`created_at` as DATE)
            ) as `completed_trainings`,
            (
                SELECT
                    COUNT(`{$this->prefix}training_user_results`.`id`) as `completed_trainings`
                FROM `{$this->prefix}training_user_results`
                LEFT JOIN `{$this->prefix}postmeta` ON `{$this->prefix}training_user_results`.`training_id` = `{$this->prefix}postmeta`.`post_id`
                LEFT JOIN `{$this->defaultPrefix}usermeta` ON `{$this->prefix}training_user_results`.`user_id` = `{$this->defaultPrefix}usermeta`.`user_id`
                WHERE
                    CAST(`{$this->prefix}training_user_results`.`created_at` as DATE) = %s AND
                    `{$this->prefix}postmeta`.`meta_key` = 'apo_user_access_permissions' AND 
                    ( `{$this->prefix}postmeta`.`meta_value` LIKE %s OR `{$this->prefix}postmeta`.`meta_value` LIKE '%no_restriction%' ) AND
                    ( `{$this->defaultPrefix}usermeta`.`meta_key` = '{$this->prefix}capabilities' AND `{$this->defaultPrefix}usermeta`.`meta_value` LIKE %s) 
                GROUP BY 
                    CAST(`{$this->prefix}training_user_results`.`created_at` as DATE)
            ) as `participated_trainings`,
            (
                SELECT 
                    COUNT(`{$this->prefix}posts`.`ID`) as `total_surveys`
                FROM `{$this->prefix}posts`
                LEFT JOIN `{$this->prefix}postmeta` ON `{$this->prefix}posts`.`ID` = `{$this->prefix}postmeta`.`post_id`
                WHERE 
                    `{$this->prefix}posts`.`post_type` = 'surveys' AND 
                    `{$this->prefix}posts`.`post_status` = 'publish' AND 
                    `{$this->prefix}postmeta`.`meta_key` = 'apo_user_access_permissions' AND 
                    ( `{$this->prefix}postmeta`.`meta_value` LIKE %s OR `{$this->prefix}postmeta`.`meta_value` LIKE '%no_restriction%' ) 
                    AND CAST(`{$this->prefix}posts`.`post_date` as DATE) = %s
                GROUP BY 
                    CAST(`{$this->prefix}posts`.`post_date` as DATE)
            ) as `total_surveys`,
            (
                SELECT
                    COUNT(`{$this->prefix}survey_user_results`.`id`) as `completed_surveys`
                FROM `{$this->prefix}survey_user_results`
                LEFT JOIN `{$this->prefix}postmeta` ON `{$this->prefix}survey_user_results`.`survey_id` = `{$this->prefix}postmeta`.`post_id`
                LEFT JOIN `{$this->defaultPrefix}usermeta` ON `{$this->prefix}survey_user_results`.`user_id` = `{$this->defaultPrefix}usermeta`.`user_id`
                WHERE
                    CAST(`{$this->prefix}survey_user_results`.`created_at` as DATE) = %s AND
                    `{$this->prefix}postmeta`.`meta_key` = 'apo_user_access_permissions' AND 
                    ( `{$this->prefix}postmeta`.`meta_value` LIKE %s OR `{$this->prefix}postmeta`.`meta_value` LIKE '%no_restriction%' ) AND  
                    `{$this->prefix}survey_user_results`.`is_complete` = 1 AND
                    ( `{$this->defaultPrefix}usermeta`.`meta_key` = '{$this->prefix}capabilities' AND `{$this->defaultPrefix}usermeta`.`meta_value` LIKE %s) 
                GROUP BY 
                    CAST(`{$this->prefix}survey_user_results`.`created_at` as DATE)
            ) as `completed_surveys`,
            (
                SELECT 
                    COUNT(`{$this->prefix}expert_points`.`id`) as `total_exchanged_expert_points_into_bonago_vouchers`
                FROM `{$this->prefix}expert_points`
                LEFT JOIN 
                    `{$this->defaultPrefix}usermeta` ON `{$this->prefix}expert_points`.`user_id` = `{$this->defaultPrefix}usermeta`.`user_id`
                WHERE 
                    CAST(`{$this->prefix}expert_points`.`created_at` as DATE) = %s AND
                    `{$this->prefix}expert_points`.`related_type` = 'bonago' AND 
                    ( `{$this->defaultPrefix}usermeta`.`meta_key` = '{$this->prefix}capabilities' AND `{$this->defaultPrefix}usermeta`.`meta_value` LIKE %s) 
                GROUP BY 
                    CAST(`{$this->prefix}expert_points`.`created_at` as DATE)
            ) as `total_exchanged_expert_points_into_bonago_vouchers`,
            (
                SELECT 
                    COUNT(`{$this->prefix}bonago_voucher_codes`.`id`) as `total_redeemed_bonago_vouchers`
                FROM `{$this->prefix}bonago_voucher_codes`
                LEFT JOIN `{$this->prefix}bonago_voucher_user` ON `{$this->prefix}bonago_voucher_codes`.`id` = `{$this->prefix}bonago_voucher_user`.`voucher_code_id`
                LEFT JOIN `{$this->defaultPrefix}usermeta` ON `{$this->prefix}bonago_voucher_user`.`user_id` = `{$this->defaultPrefix}usermeta`.`user_id`
                WHERE 
                    CAST(`{$this->prefix}bonago_voucher_codes`.`redeemed_at` as DATE) = %s AND
                    `{$this->prefix}bonago_voucher_codes`.`redeemed` = 1 AND
                    ( `{$this->defaultPrefix}usermeta`.`meta_key` = '{$this->prefix}capabilities' AND `{$this->defaultPrefix}usermeta`.`meta_value` LIKE %s) 
                GROUP BY 
                   CAST(`{$this->prefix}bonago_voucher_codes`.`redeemed_at` as DATE)
            ) as `total_redeemed_bonago_vouchers`,
            %s as `date`,           
            %s as `user_role`           
            ", $date, $escapedRole, $blogId, $escapedRole, $date, $date, $escapedRole, $escapedRole, $date, $escapedRole, $escapedRole, $escapedRole, $date, $date, $escapedRole, $escapedRole, $date, $escapedRole, $date, $escapedRole, $date, $role, $date);

        $firstResult =  $this->db->selectRow($sql);

        return (object) array_merge( (array) $firstResult, (array) $this->getDailyStatsForRatingKeyQuestionsAveragePerUserRole($date, $role) );
    }

    public function getDailyStatsPerJobRole($date, $role)
    {
        $blogId = get_current_blog_id();
        
        $escapedRole = '%' . $this->db->wpdb->esc_like($role) . '%';

        $sql = $this->db->prepare("
            SELECT (
                SELECT 
                    COUNT(`{$this->defaultPrefix}users`.`ID`) as `total_users`
                FROM `{$this->defaultPrefix}users`
                LEFT JOIN
                    `{$this->defaultPrefix}usermeta` ON `{$this->defaultPrefix}users`.`ID` = `{$this->defaultPrefix}usermeta`.`user_id`
                WHERE 
                    CAST(`{$this->defaultPrefix}users`.`user_registered` as DATE) <= %s AND 
                    ( `{$this->defaultPrefix}usermeta`.`meta_key` = 'job' AND 
                    `{$this->defaultPrefix}usermeta`.`meta_value` LIKE %s ) AND
                    (SELECT wp_um.meta_value FROM `{$this->defaultPrefix}usermeta` AS wp_um WHERE wp_um.user_id = `{$this->defaultPrefix}users`.`ID` AND wp_um.meta_key = 'primary_blog') = %s
                GROUP BY 
                    `{$this->defaultPrefix}usermeta`.`meta_value`
            ) as `total_users`,
            %s as `job_role` ,          
            %s as `date`   
            ", $date, $role, $blogId, $role, $date);

        $firstResult =  $this->db->selectRow($sql);

        return $firstResult;
    }

    public function getDailyStatsPerDownload($date)
    {

        $sql = $this->db->prepare("
        SELECT  {$this->prefix}posts.ID as download_id,
            {$this->prefix}posts.post_title as download_title,
            (SELECT 
                name 
            FROM 
                {$this->prefix}terms as wt 
            JOIN 
                {$this->prefix}term_taxonomy as wtt ON wt.term_id = wtt.term_id AND wtt.taxonomy = 'dwnld-product' 
            WHERE 
                wtt.term_taxonomy_id IN (SELECT term_taxonomy_id FROM {$this->prefix}term_relationships WHERE object_id = download_id)) as product_title,
            (SELECT 
                name 
            FROM 
                {$this->prefix}terms as wt 
            JOIN 
                {$this->prefix}term_taxonomy as wtt ON wt.term_id = wtt.term_id AND wtt.taxonomy = 'dwnld-mediatype' 
            WHERE 
                wtt.term_taxonomy_id IN (SELECT term_taxonomy_id FROM {$this->prefix}term_relationships WHERE object_id = download_id)) as download_mediatype,
            (SELECT meta_value FROM {$this->prefix}postmeta WHERE meta_key = 'downloads' AND post_id = download_id) as total_downloads,
            %s as `date`
        FROM {$this->prefix}posts
        WHERE
            {$this->prefix}posts.post_parent = '0' AND
            {$this->prefix}posts.post_type = 'downloads'
        ", $date);

        return $this->db->select($sql);
    }

    public function getDailyStatsPerSurvey($date)
    {

        $sql = $this->db->prepare("
        SELECT  {$this->prefix}posts.ID as survey_id,
            {$this->prefix}posts.post_title as survey_title,
            (SELECT COUNT(id) FROM {$this->prefix}survey_user_results WHERE survey_id = {$this->prefix}posts.ID AND is_complete = 1 AND CAST(`created_at` as DATE) = %s) as total_done,
            %s as `date`
        FROM {$this->prefix}posts
        WHERE
            {$this->prefix}posts.post_parent = '0' AND
            {$this->prefix}posts.post_type = 'surveys'
        ", $date, $date);
        
        return $this->db->select($sql);
    }

    public function getDailyStatsPerActivation($date)
    {

        $sql = $this->db->prepare("
        SELECT  
            {$this->prefix}expert_codes.expert_code_name as activation_name,
            {$this->prefix}expert_codes.expert_code,
            COUNT({$this->defaultPrefix}usermeta.meta_value) AS activations,
            {$this->prefix}expert_codes.usages,
            %s as `date`
        FROM {$this->defaultPrefix}usermeta
        INNER JOIN {$this->prefix}expert_codes ON {$this->defaultPrefix}usermeta.meta_key = 'registered_expert_code' AND {$this->defaultPrefix}usermeta.meta_value = {$this->prefix}expert_codes.expert_code
        GROUP BY {$this->defaultPrefix}usermeta.meta_value
        ", $date);
        
        return $this->db->select($sql);
    }

    public function getDailyStatsPerTraining($date)
    {

        $sql = $this->db->prepare("
        SELECT  {$this->prefix}posts.ID as training_id,
            {$this->prefix}posts.post_title as training_title,
            (SELECT COUNT(id) FROM {$this->prefix}training_user_results WHERE training_id = {$this->prefix}posts.ID AND is_complete = 1 AND CAST(`created_at` as DATE) = %s) as total_done,
            %s as `date`
        FROM {$this->prefix}posts
        WHERE
            {$this->prefix}posts.post_parent = '0' AND
            {$this->prefix}posts.post_type = 'trainings'
        ", $date, $date);

        return $this->db->select($sql);
    }

    public function getDailyStatsPerSalesRep($date)
    {
        $sql = $this->db->prepare("
            SELECT 
                `{$this->prefix}expert_codes`.`sales_rep_user_id`,
                `usermeta_1`.`user_id`,
                `usermeta_1`.`meta_value` as `registered_expert_code`,
                `usermeta_2`.`meta_value` as `registered_pharmacy_id`,
                `{$this->prefix}apovoice_pharmacies`.`pharmacy_unique_number` as `pharmacy_unique_number`,
                `{$this->prefix}apovoice_pharmacies`.`name` as `pharmacy_name`,
                CAST(`{$this->defaultPrefix}users`.`user_registered` as DATE) as `date`
            FROM `{$this->prefix}expert_codes`
            LEFT JOIN `{$this->defaultPrefix}usermeta` as `usermeta_1` ON 'registered_expert_code' = `usermeta_1`.`meta_key` AND `{$this->prefix}expert_codes`.`expert_code` = `usermeta_1`.`meta_value`
            LEFT JOIN `{$this->defaultPrefix}usermeta` as `usermeta_2` ON 'registered_pharmacy_unique_number' = `usermeta_2`.`meta_key` AND  `usermeta_1`.`user_id` = `usermeta_2`.`user_id`
            LEFT JOIN `{$this->prefix}apovoice_pharmacies` ON  `usermeta_2`.`meta_value` = `{$this->prefix}apovoice_pharmacies`.`id`
            LEFT JOIN `{$this->defaultPrefix}users` ON `{$this->defaultPrefix}users`.`ID` =  `usermeta_1`.`user_id`
            WHERE 
                CAST(`{$this->defaultPrefix}users`.`user_registered` as DATE) = %s
        ", $date);

        return $this->db->select($sql);
    }

    public function getDailyStatsPerTrainingCategory($date)
    {
        $sql = $this->db->prepare("
        SELECT 
            `{$this->prefix}terms`.`slug` as `category_name`,
            COUNT(`{$this->prefix}terms`.`slug`) as `total_trainings_per_category`,
            CAST(`training_posts`.`post_date` as DATE) as `date`,
            `training_posts`.`ID` as `training_id`
        FROM `{$this->prefix}term_taxonomy` 
        LEFT JOIN `{$this->prefix}terms` ON `{$this->prefix}term_taxonomy`.`term_id` = `{$this->prefix}terms`.`term_id`
        LEFT JOIN `{$this->prefix}term_relationships` ON `{$this->prefix}terms`.`term_id` = `{$this->prefix}term_relationships`.`term_taxonomy_id`
        LEFT JOIN `{$this->prefix}postmeta` ON `{$this->prefix}term_relationships`.`object_id` = `{$this->prefix}postmeta`.`post_id`
        LEFT JOIN `{$this->prefix}posts` as `training_posts` ON `{$this->prefix}postmeta`.`meta_value` = `training_posts`.`ID`
        WHERE 
            `{$this->prefix}term_taxonomy`.`taxonomy` = 'training-category' 
            AND `{$this->prefix}term_relationships`.`object_id` IS NOT NULL
            AND `{$this->prefix}postmeta`.`meta_key` LIKE 'trainings_%_training_id'
            AND CAST(`training_posts`.`post_date` as DATE) = %s
            AND `training_posts`.`post_status` = 'publish'
        GROUP BY `{$this->prefix}terms`.`slug`, CAST(`training_posts`.`post_date` as DATE)
        ", $date);
        
        $firstResult = $this->db->select($sql);

        return array_map( function($trainingCategory) use ($date) {
            return (object) array_merge( (array) $trainingCategory, $this->getDailyStatsForRatingKeyQuestionsAveragePerTrainigsCategory($trainingCategory->training_id, $date));
        }, (array) $firstResult);
    }

    public function getDailyStatsPerTrainingCategoryPerUserRole($date, $role)
    {
        $escapedRole = '%' . $this->db->wpdb->esc_like($role) . '%';

        $sql = $this->db->prepare("
            SELECT 
                `{$this->prefix}terms`.`slug` as `category_name`,
                %s as `user_role`,
                COUNT(DISTINCT `{$this->prefix}postmeta`.`meta_value`) as `total_trainings_per_category`,
                COUNT(`{$this->prefix}training_user_results`.`training_id`) as `total_completed_trainings_per_category`,
                CAST(`{$this->prefix}training_user_results`.`created_at` as DATE) as `date`,
                `training_posts`.`ID` as `training_id`
            FROM `{$this->prefix}term_taxonomy` 
            LEFT JOIN `{$this->prefix}terms` ON `{$this->prefix}term_taxonomy`.`term_id` = `{$this->prefix}terms`.`term_id`
            LEFT JOIN `{$this->prefix}term_relationships` ON `{$this->prefix}terms`.`term_id` = `{$this->prefix}term_relationships`.`term_taxonomy_id`
            LEFT JOIN `{$this->prefix}postmeta` ON `{$this->prefix}term_relationships`.`object_id` = `{$this->prefix}postmeta`.`post_id`
            LEFT JOIN `{$this->prefix}posts` as `training_posts` ON `{$this->prefix}postmeta`.`meta_value` = `training_posts`.`ID`
            LEFT JOIN `{$this->prefix}training_user_results` ON `{$this->prefix}postmeta`.`meta_value` = `{$this->prefix}training_user_results`.`training_id`
            LEFT JOIN `{$this->defaultPrefix}usermeta` ON `{$this->prefix}training_user_results`.`user_id` = `{$this->defaultPrefix}usermeta`.`user_id`
            WHERE 
                `{$this->prefix}term_taxonomy`.`taxonomy` = 'training-category' 
                AND `{$this->prefix}term_relationships`.`object_id` IS NOT NULL
                AND `{$this->prefix}postmeta`.`meta_key` LIKE 'trainings_%_training_id'
                AND `{$this->prefix}training_user_results`.`is_complete` = 1
                AND ( `{$this->defaultPrefix}usermeta`.`meta_key` = '{$this->defaultPrefix}capabilities' AND `{$this->defaultPrefix}usermeta`.`meta_value` LIKE %s) 
                AND CAST(`{$this->prefix}training_user_results`.`created_at` as DATE) = %s
                AND `training_posts`.`post_status` = 'publish'
            GROUP BY `{$this->prefix}terms`.`slug`, CAST(`{$this->prefix}training_user_results`.`created_at` as DATE)
        ", $role, $role, $date);

        $firstResult = $this->db->select($sql);

        return array_map( function($trainingCategory) use ($date, $role) {
            return (object) array_merge( (array) $trainingCategory, $this->getDailyStatsForRatingKeyQuestionsAveragePerTrainigsCategoryPerUserRole($trainingCategory->training_id, $date, $role));
        }, (array) $firstResult);
    }

    public function getDailyStatsForRatingKeyQuestionsAverage($date)
    {
        $sql = $this->db->prepare("
            SELECT 
                *
            FROM `{$this->prefix}training_question_user_results` 
            WHERE
                `{$this->prefix}training_question_user_results`.`question_type` = 'rating'
                AND CAST(`{$this->prefix}training_question_user_results`.`created_at` as DATE) = %s
        ", $date);

        $result = $this->db->select($sql);

        return $this->createKeyQuestionResponse($result);
    }

    public function getDailyStatsForRatingKeyQuestionsAveragePerUserRole($date, $role)
    {
        $escapedRole = '%' . $this->db->wpdb->esc_like($role) . '%';

        $sql = $this->db->prepare("
            SELECT 
                *
            FROM `{$this->prefix}training_question_user_results` 
            WHERE
                `{$this->prefix}training_question_user_results`.`question_type` = 'rating'
                AND CAST(`{$this->prefix}training_question_user_results`.`created_at` as DATE) = %s
                AND `{$this->prefix}training_question_user_results`.`user_id` IN 
                (
                    SELECT
                        `{$this->defaultPrefix}users`.`ID`
                    FROM `{$this->defaultPrefix}users`
                    LEFT JOIN
                        `{$this->defaultPrefix}usermeta` ON `{$this->defaultPrefix}users`.`ID` = `{$this->defaultPrefix}usermeta`.`user_id`
                    WHERE
                        `{$this->defaultPrefix}usermeta`.`meta_key` = '{$this->defaultPrefix}capabilities' 
                        AND `{$this->defaultPrefix}usermeta`.`meta_value` LIKE %s 
                )
        ", $date, $escapedRole);

        $result = $this->db->select($sql);

        return $this->createKeyQuestionResponse($result);
    }

    public function getDailyStatsForRatingKeyQuestionsAveragePerTrainigsCategory($training_id, $date)
    {
        $sql = $this->db->prepare("
            SELECT 
                *
            FROM `{$this->prefix}training_question_user_results` 
            WHERE
                `{$this->prefix}training_question_user_results`.`question_type` = 'rating' 
                AND `{$this->prefix}training_question_user_results`.`training_id` = %s 
                AND CAST(`{$this->prefix}training_question_user_results`.`created_at` as DATE) = %s
        ", $training_id, $date);

        $result = $this->db->select($sql);

        return $this->createKeyQuestionResponse($result);
    }

    public function getDailyStatsForRatingKeyQuestionsAveragePerTrainigsCategoryPerUserRole($training_id, $date, $role)
    {
        $escapedRole = '%' . $this->db->wpdb->esc_like($role) . '%';

        $sql = $this->db->prepare("
            SELECT 
                *
            FROM `{$this->prefix}training_question_user_results` 
            WHERE
                `{$this->prefix}training_question_user_results`.`question_type` = 'rating' 
                AND `{$this->prefix}training_question_user_results`.`training_id` = %s 
                AND CAST(`{$this->prefix}training_question_user_results`.`created_at` as DATE) = %s
                AND `{$this->prefix}training_question_user_results`.`user_id` IN 
                (
                    SELECT
                        `{$this->defaultPrefix}users`.`ID`
                    FROM `{$this->defaultPrefix}users`
                    LEFT JOIN
                        `{$this->defaultPrefix}usermeta` ON `{$this->defaultPrefix}users`.`ID` = `{$this->defaultPrefix}usermeta`.`user_id`
                    WHERE
                        `{$this->defaultPrefix}usermeta`.`meta_key` = '{$this->defaultPrefix}capabilities' 
                        AND `{$this->defaultPrefix}usermeta`.`meta_value` LIKE %s 
                )
        ", $training_id, $date, $escapedRole);

        $result = $this->db->select($sql);

        return $this->createKeyQuestionResponse($result);
    }

    protected function createKeyQuestionResponse($result)
    {
        return [
            'total_done_key_questions' => sizeof($result),
            'total_sum_done_key_question_points' => array_sum(
                array_map(function($r) {
                    return maybe_unserialize($r->result)[0]['user_answer']['value'];
                }, $result)
            ),
        ];
    }

}