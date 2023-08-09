<?php

namespace apo\bonago;

use apo\bonago\roles\BonagoVoucherSubscriberRole;
use apo\bonago\roles\BonagoVoucherManagerRole;
use awsm\wp\libraries\DB;
use awsm\wp\libraries\utilities\DatabaseUtils;
use awsm\wp\libraries\utilities\Migratable;
use awsm\wp\libraries\interfaces\CreateSchemasInterface;

class Bootstrap implements CreateSchemasInterface {

    use DatabaseUtils, Migratable;

    public $bonagoVoucherManagerRole;

    public $bonagoVoucherSubscriberRole;

    protected $db;

    protected $networkWide;

	protected $schemas;

    public function __construct($networkWide = true)
    {
        $this->db = DB::instance();
        $this->schemas = [];
        $this->networkWide = $networkWide;
        $this->bonagoVoucherManagerRole = new BonagoVoucherManagerRole($networkWide);
        $this->bonagoVoucherSubscriberRole = new BonagoVoucherSubscriberRole($networkWide);

        return $this;
    }

    public function createSchemas()
    {
        $this->createBonagoVoucherCodesSchema()
            ->createBonagoVoucherUserSchema();

        return $this;
    }

    protected function createBonagoVoucherCodesSchema()
    {
        $tableName = $this->createTableName('bonago_voucher_codes');

        $table = "CREATE TABLE `{$tableName}` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `voucher_code` varchar(64) NOT NULL,
            `assigned` tinyint unsigned NOT NULL DEFAULT 0,
            `redeemed` tinyint unsigned NOT NULL DEFAULT 0,
            `assigned_at` timestamp NULL DEFAULT NULL,
            `redeemed_at` timestamp NULL DEFAULT NULL,
            `expires_at` date DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE( `voucher_code` )
        )" . $this->db->wpdb->get_charset_collate();

        $this->addSchema($table);

        return $this;
    }

    protected function createBonagoVoucherUserSchema()
    {
        $tableName = $this->createTableName('bonago_voucher_user');

        $table = "CREATE TABLE `{$tableName}` (
            `voucher_code_id` int(11) unsigned NOT NULL,
            `user_id` int(11) unsigned NOT NULL,
            UNIQUE KEY `voucer_code_id` ( `voucher_code_id` ),
            UNIQUE KEY `voucer_code_id_user_id` ( `voucher_code_id`, `user_id` )
        )" . $this->db->wpdb->get_charset_collate();

        $this->addSchema($table);

        return $this;
    }

    public function down()
    {
        $this->bonagoVoucherManagerRole->remove();
        $this->bonagoVoucherSubscriberRole->remove();

        return $this;
    }

    public function createRoles()
    {
        $this->bonagoVoucherManagerRole->create();
        $this->bonagoVoucherSubscriberRole->create();

        return $this;
    }

}
