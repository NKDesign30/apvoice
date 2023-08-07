<?php

namespace apo\expertpoints;

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
        $this->createExpertPointsSchema();
        return $this;
    }

    protected function createExpertPointsSchema()
    {
        $tableName = $this->createTableName('expert_points');
        $table = 'CREATE TABLE ' . $tableName . ' (
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `user_id` INT(11) UNSIGNED NOT NULL,
            `points_earned` SMALLINT(5) NOT NULL,
            `related_type` VARCHAR(255) NOT NULL,
            `related_id` INT(11) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            INDEX (`user_id`),
            INDEX (`related_id`),
            UNIQUE (`user_id`, `related_id`, `related_type`)
        )' . $this->db->wpdb->get_charset_collate();
        
        $this->addSchema($table);
        return $this;
    }

}
