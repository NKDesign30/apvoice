<?php

namespace apo\rxts;

use awsm\wp\libraries\DB;
use awsm\wp\libraries\utilities\DatabaseUtils;
use awsm\wp\libraries\utilities\Migratable;
use awsm\wp\libraries\interfaces\CreateSchemasInterface;

class Bootstrap implements CreateSchemasInterface {

    use DatabaseUtils, Migratable;

    protected $db;
    protected $networkWide;
	protected $schemas;
    
    public function __construct($networkWide = true) 
    {
        $this->db = DB::instance();
        $this->schemas = [];
        $this->networkWide = $networkWide;
        return $this;
    }

    public function createSchemas()
    {
        $this->createPharmacyUserSchema()
            ->createTrainingQuestionUserResultsSchema();
        return $this;
    }

    protected function createPharmacyUserSchema()
    {
        $tableName = $this->createTableName('apovoice_pharmacy_user');
        $table = "CREATE TABLE `{$tableName}` (
            pharmacy_id bigint(20) NOT NULL,
            user_id bigint(20) unsigned NOT NULL,
            created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (pharmacy_id,user_id),
            KEY user_id (user_id)
        )" . $this->db->wpdb->get_charset_collate();
        
        $this->addSchema($table);
        return $this;
    }

    protected function createTrainingQuestionUserResultsSchema()
    {
        $tableName = $this->createTableName('training_question_user_results');
        $table = "CREATE TABLE `{$tableName}` (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            user_id INT(11) UNSIGNED NOT NULL,
            training_id INT(11) UNSIGNED NOT NULL,
            question_id VARCHAR(255) NOT NULL,
            lesson_id VARCHAR(255) NOT NULL,
            question_type VARCHAR(255) NOT NULL,
            result LONGTEXT NULL DEFAULT NULL,
            created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY unique_question_result (user_id, training_id, question_id, lesson_id)
        )" . $this->db->wpdb->get_charset_collate();
        
        $this->addSchema($table);
        return $this;
    }

}
