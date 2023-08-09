<?php

namespace apo\migration;

use awsm\wp\libraries\DB;
use awsm\wp\libraries\utilities\DatabaseUtils;
use awsm\wp\libraries\utilities\Migratable;
use awsm\wp\libraries\interfaces\CreateSchemasInterface;

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
        return $this;
    }

    public function createPrimaryBlogSchemas() 
    {
        $this->createMigrationStatusSchema()
            ->seedMigrationStatusTable();

        return $this;
    }

    protected function createMigrationStatusSchema()
    {
        $tableName = $this->createTableName('apo_migration_status');

        $table = "CREATE TABLE `{$tableName}` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `trainings_migrated` tinyint(4) NOT NULL DEFAULT 0,
            `surveys_migrated` tinyint(4) NOT NULL DEFAULT 0,
            `users_migrated` tinyint(4) NOT NULL DEFAULT 0,
            `survey_user_results_migrated` tinyint(4) NOT NULL DEFAULT 0,
            `training_quiz_results_migrated` tinyint(4) NOT NULL DEFAULT 0,
            `voucher_codes_migrated` tinyint(4) NOT NULL DEFAULT 0,
            `expert_codes_migrated` tinyint(4) NOT NULL DEFAULT 0,
            PRIMARY KEY (`id`)
        )" . $this->db->wpdb->get_charset_collate();
        
        $this->addPrimaryBlogSchema($table);
        return $this;
    }

    protected function seedMigrationStatusTable()
    {
        $tableName = $this->createTableName('apo_migration_status');

        $sql = "INSERT INTO `{$tableName}`
            (
                `id`, 
                `trainings_migrated`, 
                `surveys_migrated`, 
                `users_migrated`, 
                `survey_user_results_migrated`, 
                `training_quiz_results_migrated`, 
                `voucher_codes_migrated`, 
                `expert_codes_migrated`
            )
            VALUES
            ('1', '0', '0', '0', '0', '0', '0', '0');
        ";

        $this->addPrimaryBlogSchema($sql);
        return $this;
    }

    public function down()
    {   
        $tableName = $this->db->wpdb->prefix . 'apo_migration_status';
        $this->db->wpdb->query( "DROP TABLE IF EXISTS {$tableName}" );
        return $this;
    }

}
