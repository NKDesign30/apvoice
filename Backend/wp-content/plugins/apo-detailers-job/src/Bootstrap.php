<?php

namespace apo\detailersjob;

use apo\detailersjob\roles\DetailersJobManagerRole;
use awsm\wp\libraries\DB;
use awsm\wp\libraries\utilities\DatabaseUtils;
use awsm\wp\libraries\utilities\Migratable;
use awsm\wp\libraries\interfaces\CreateSchemasInterface;

class Bootstrap implements CreateSchemasInterface
{
    use DatabaseUtils, Migratable;

    public $detailersJobManagerRole;

    protected $db;

    protected $networkWide;

    protected $schemas;

    public function __construct($networkWide = true)
    {
        $this->db = DB::instance();
        $this->schemas = [];
        $this->networkWide = $networkWide;
        $this->detailersJobManagerRole = new DetailersJobManagerRole($networkWide);

        return $this;
    }

    public function createSchemas()
    {
        $this->createDetailersJobSavedStateSchema();

        return $this;
    }

    protected function createDetailersJobSavedStateSchema()
    {
        $tableName = $this->createTableName('detailers_job_saved_state');

        $table = 'CREATE TABLE ' . $tableName . ' (
            `informational_training_id` varchar(64) NOT NULL,
            `detailer_user_id` bigint(20) unsigned NOT NULL,
            `pharmacy_id` bigint(20) NOT NULL,
            `last_question_id` varchar(64) NOT NULL,
            `created_at` timestamp NOT NULL,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (informational_training_id, detailer_user_id, pharmacy_id)
        )' . $this->db->wpdb->get_charset_collate();

        $this->addSchema($table);

        return $this;
    }

    public function down()
    {
        $this->detailersJobManagerRole->remove();

        return $this;
    }
}
