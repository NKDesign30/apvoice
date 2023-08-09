<?php

namespace apo\pun;

use apo\pun\roles\PUNSubscriberRole;
use apo\pun\roles\PUNManagerRole;
use awsm\wp\libraries\DB;
use awsm\wp\libraries\utilities\DatabaseUtils;
use awsm\wp\libraries\utilities\Migratable;
use awsm\wp\libraries\interfaces\CreateSchemasInterface;

class Bootstrap implements CreateSchemasInterface {

    use DatabaseUtils, Migratable;

    public $punManagerRole;

    public $punSubscriberRole;

    protected $db;

    protected $networkWide;

    protected $schemas;

    public function __construct($networkWide = true)
    {
        $this->db = DB::instance();
        $this->schemas = [];
        $this->networkWide = $networkWide;
        $this->punManagerRole = new PUNManagerRole($networkWide);
        $this->punSubscriberRole = new PUNSubscriberRole($networkWide);
        
        return $this;
    }

    public function createSchemas()
    {
        $this->createRolesShema();
        $this->createPharmaciesSchema();

        return $this;
    }

    protected function createPharmaciesSchema()
    {
        $tableName = $this->createTableName('apovoice_pharmacies');
        $table = "CREATE TABLE `{$tableName}` (
            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            `pharmacy_unique_number` VARCHAR(20) NOT NULL,
            `name` VARCHAR(255) NOT NULL,
            `role_id` bigint(20) DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY pharmacy_unique_number (`pharmacy_unique_number`)
        )" . $this->db->wpdb->get_charset_collate();
        
        $this->addSchema($table);
        return $this;
    }

 /*   protected function createTrainingRoles()
    {
        $tableName = $this->createTableName('apovoice_training_roles');
        $table = "CREATE TABLE `{$tableName}` (
            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            `pun_code` VARCHAR(20) NOT NULL,
            `role_id` bigint(20) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY id (`id`)
        )" . $this->db->wpdb->get_charset_collate();
        
        $this->addSchema($table);
        return $this;
    }
*/


    protected function createRolesShema()
    {
        $tableName = $this->createTableName('apovoice_roles');
        $table = "CREATE TABLE `{$tableName}` (
            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(255) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY name (`name`)
        )" . $this->db->wpdb->get_charset_collate();
        
        $this->addSchema($table);
        return $this;
    }

   


    public function down()
    {
        $this->punManagerRole->remove();
        $this->punSubscriberRole->remove();

        return $this;
    }

    public function createRoles()
    {
        $this->punManagerRole->create();
        $this->punSubscriberRole->create();
        global $wp_roles;
        global $wpdb;


        //make combinaison of pun_code & role id unique
    //    $wpdb->query("CREATE UNIQUE INDEX arbitrary_index_name ON wp_apovoice_training_roles (role_id, pun_code);");

    
        //get all roles in wordpress site and insert into the new table
        $all_roles = $wp_roles->roles;
        $editable_roles = apply_filters('editable_roles', $all_roles);
        foreach($editable_roles as $role){
            $wpdb->insert("wp_apovoice_roles" , array('name' => $role["name"] ));
        }



        //get all pharmacy codes from spain table
        $sql1 = "SELECT * FROM wp_apovoice_pharmacies";
        $pharmacies = $wpdb->get_results($sql1);



        //get all pharmacy codes from spain table
        $sql2 = "SELECT * FROM wp_apovoice_roles where name='HCP'";
        $role = $wpdb->get_results($sql2);


       // default role to every pharmacy
       $wpdb->query( 
        $wpdb->prepare( 
            "UPDATE wp_apovoice_pharmacies
             SET `role_id` = %d",
             $role[0]->id
        )
    );

    
     
        







        return $this;
    }

}
