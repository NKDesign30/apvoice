<?php

namespace awsm\wp\libraries\utilities;

trait DatabaseUtils 
{    
    protected function createTableName($tableName)
    {
        return $this->db->wpdb->prefix . $tableName;
    }

    protected function tableExists($tableName)
    {
        return !$this->db->wpdb->get_var( "show tables like '{$tableName}'" ) != $tableName;
    }
}