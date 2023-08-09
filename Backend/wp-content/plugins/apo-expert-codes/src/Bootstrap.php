<?php

namespace apo\expertcodes;

use apo\expertcodes\roles\ExpertCodeSubscriberRole;
use apo\expertcodes\roles\ExpertCodeManagerRole;
use awsm\wp\libraries\DB;
use awsm\wp\libraries\utilities\DatabaseUtils;
use awsm\wp\libraries\utilities\Migratable;
use awsm\wp\libraries\interfaces\CreateSchemasInterface;

class Bootstrap implements CreateSchemasInterface {

    use DatabaseUtils, Migratable;

    public $expertCodeManagerRole;

    public $expertCodeSubscriberRole;

    protected $db;

    protected $networkWide;

	protected $schemas;

    public function __construct($networkWide = true)
    {
        $this->db = DB::instance();
        $this->schemas = [];
        $this->networkWide = $networkWide;
        $this->expertCodeManagerRole = new ExpertCodeManagerRole($networkWide);
        $this->expertCodeSubscriberRole = new ExpertCodeSubscriberRole($networkWide);
        
        return $this;
    }

    public function createSchemas()
    {
        $this->createExpertCodesSchema();

        return $this;
    }

    protected function createExpertCodesSchema()
    {
        $tableName = $this->createTableName('expert_codes');

        $table = "CREATE TABLE `{$tableName}` (
            `expert_code` varchar(64) NOT NULL,
            `sales_rep_user_id` bigint(20) unsigned NOT NULL,
            `expert_code_name` varchar(255) unsigned NOT NULL,
            `usages` int(11) unsigned DEFAULT NULL,
            `used` int(11) unsigned NOT NULL DEFAULT 0,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`expert_code`)
        )" . $this->db->wpdb->get_charset_collate();

        $this->addSchema($table);

        return $this;
    }

    public function down()
    {
        $this->expertCodeManagerRole->remove();
        $this->expertCodeSubscriberRole->remove();

        return $this;
    }

    public function createRoles()
    {
        $this->expertCodeManagerRole->create();
        $this->expertCodeSubscriberRole->create();

        return $this;
    }


}
