<?php

namespace raffle;

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
        $tableName = $this->createTableName('apo_raffle');
        $table = 'CREATE TABLE ' . $tableName . ' (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            user_id INT(11) UNSIGNED NOT NULL,
            raffle_id INT(11) UNSIGNED NOT NULL,
            contest VARCHAR(128) NOT NULL,
            firstName VARCHAR(128) NOT NULL,
            lastName VARCHAR(128) NOT NULL,
            pharmacyCity VARCHAR(128) NOT NULL, 
            pharmacyName VARCHAR(256) NOT NULL,
            pharmacyStreet VARCHAR(256) NOT NULL,
            pharmacyCountry VARCHAR(128) NOT NULL,
            pharmacyZipCode VARCHAR(16) NOT NULL,
            pharmacyStreetNumber VARCHAR(16) NOT NULL,
            PRIMARY KEY (id)
        )' . $this->db->wpdb->get_charset_collate();

        $this->addSchema($table);
        return $this;
    }

}
