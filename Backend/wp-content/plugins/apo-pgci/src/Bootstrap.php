<?php

namespace apo\pgci;

use apo\pgci\roles\PGCISubscriberRole;
use apo\pgci\roles\PGCIManagerRole;
use awsm\wp\libraries\DB;
use awsm\wp\libraries\utilities\DatabaseUtils;
use awsm\wp\libraries\utilities\Migratable;
use awsm\wp\libraries\interfaces\CreateSchemasInterface;

class Bootstrap implements CreateSchemasInterface {

    use DatabaseUtils, Migratable;

    public $pgciManagerRole;

    public $pgciSubscriberRole;

    protected $db;

    protected $networkWide;

    protected $schemas;

    public function __construct($networkWide = true)
    {
        $this->db = DB::instance();
        $this->schemas = [];
        $this->networkWide = $networkWide;
        $this->pgciManagerRole = new PGCIManagerRole($networkWide);
        $this->pgciSubscriberRole = new PGCISubscriberRole($networkWide);

        return $this;
    }

    public function createSchemas()
    {
        $this->createPharmaciesSchema();

        return $this;
    }


  

    protected function createPharmaciesSchema()
    {
        $tableName = $this->createTableName('apovoice_pgci');
        $table = "CREATE TABLE `{$tableName}` (
            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            `bga_id` VARCHAR(255) NOT NULL,
            `name`  VARCHAR(255) NOT NULL,
            `house_nr` VARCHAR(255) NOT NULL,
            `street` VARCHAR(255) NOT NULL,
            `zip_code` VARCHAR(255) NOT NULL,
            `city` VARCHAR(255) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY id(`id`)
        )" . $this->db->wpdb->get_charset_collate();
        
        $this->addSchema($table);
        return $this;
    }

    public function down()
    {
        $this->pgciManagerRole->remove();
        $this->pgciSubscriberRole->remove();

        return $this;
    }

    public function createRoles()
    {
        $this->pgciManagerRole->create();
        $this->pgciSubscriberRole->create();

        return $this;
    }

}
