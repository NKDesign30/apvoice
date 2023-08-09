<?php

namespace apo\trng;

use apo\trng\roles\TrainingManagerRole;
use awsm\wp\libraries\DB;
use awsm\wp\libraries\utilities\DatabaseUtils;
use awsm\wp\libraries\utilities\Migratable;
use awsm\wp\libraries\interfaces\CreateSchemasInterface;

class Bootstrap implements CreateSchemasInterface {

    use DatabaseUtils, Migratable;
    
    public $trainingManagerRole;

    protected $db;

    protected $networkWide;

    protected $schemas;
    
    public function __construct($networkWide = true) 
    {
        $this->db = DB::instance();
        $this->schemas = [];
        $this->networkWide = $networkWide;
        $this->trainingManagerRole = new TrainingManagerRole($networkWide);
        return $this;
    }

    public function createSchemas()
    {
        $this->createTrainingUserResultsSchema()
            ->createTrainingUserLessonsSchema();
        return $this;
    }

    protected function createTrainingUserResultsSchema()
    {
        $tableName = $this->createTableName('training_user_results');
        $table = 'CREATE TABLE ' . $tableName . ' (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            user_id INT(11) UNSIGNED NOT NULL,
            training_id INT(11) UNSIGNED NOT NULL,
            result LONGTEXT NULL DEFAULT NULL,
            is_complete TINYINT NOT NULL DEFAULT 0,
            created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE (user_id, training_id)
        )' . $this->db->wpdb->get_charset_collate();
        
        $this->addSchema($table);
        return $this;
    }

    protected function createTrainingUserLessonsSchema()
    {
        $tableName = $this->createTableName('training_user_lessons');
        $table = 'CREATE TABLE ' . $tableName . ' (
            training_id INT(11) UNSIGNED NOT NULL,
            user_id INT(11) UNSIGNED NOT NULL,
            lesson_id VARCHAR(255) NOT NULL,
            created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE (training_id, user_id, lesson_id)
        )' . $this->db->wpdb->get_charset_collate();
        
        $this->addSchema($table);
        return $this;
    }

    public function down()
    {
        $this->trainingManagerRole->remove();

        return $this;
    }

}
