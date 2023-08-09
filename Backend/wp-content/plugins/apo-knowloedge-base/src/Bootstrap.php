<?php

namespace knwldg;

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
        $this->createAWSMRocksSchema();
        return $this;
    }

    protected function createAWSMRocksSchema()
    {
        $tableName = $this->createTableName('apo_knowledge_base');
        $table = 'CREATE TABLE ' . $tableName . ' (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            user_id INT(11) UNSIGNED NOT NULL,
            blog_id INT(11) UNSIGNED NOT NULL,
            PRIMARY KEY (id),
            UNIQUE (user_id, blog_id)
        )' . $this->db->wpdb->get_charset_collate();
        
        $this->addSchema($table);
        return $this;
    }

}
