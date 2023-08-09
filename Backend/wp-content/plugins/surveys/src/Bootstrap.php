<?php

namespace apo\svy;
use apo\svy\roles\SurveyManagerRole;
use awsm\wp\libraries\DB;
use awsm\wp\libraries\utilities\Migratable;
use awsm\wp\libraries\utilities\DatabaseUtils;
use awsm\wp\libraries\interfaces\CreateSchemasInterface;

class Bootstrap implements CreateSchemasInterface {

    use DatabaseUtils, Migratable;

    public $surveyManagerRole;

    protected $db;

    protected $networkWide;

    protected $schemas;
    
    public function __construct($networkWide = true) 
    {
        $this->db = DB::instance();
        $this->schemas = [];
        $this->networkWide = $networkWide;
        $this->surveyManagerRole = new SurveyManagerRole($networkWide);

        return $this;
    }

    public function createSchemas()
    {
        $this->createSurveyUserResultsSchema();
        return $this;
    }

    protected function createSurveyUserResultsSchema()
    {
        $tableName = $this->createTableName('survey_user_results');
        $table = 'CREATE TABLE ' . $tableName . ' (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            user_id INT(11) UNSIGNED NOT NULL,
            survey_id INT(11) UNSIGNED NOT NULL,
            result LONGTEXT NULL DEFAULT NULL,
            is_complete TINYINT NOT NULL DEFAULT 0,
            created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE (user_id, survey_id)
        )' . $this->db->wpdb->get_charset_collate();
        
        $this->addSchema($table);
        return $this;
    }

    public function down()
    {
        $this->surveyManagerRole->remove();

        return $this;
    }

}
