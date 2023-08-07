<?php

namespace dwnld;

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
        $this->createApoDownloadsSchema();
        return $this;
    }

    protected function createApoDownloadsSchema()
    {
        $tableName = $this->createTableName('apo_downloads');
        $table = 'CREATE TABLE ' . $tableName . ' (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            PRIMARY KEY (id)
        )' . $this->db->wpdb->get_charset_collate();
        
        $this->addSchema($table);
        return $this;
    }

}
