<?php 

namespace apo\migration\utilities;

class MigrationDatabaseConnector 
{
    public static function instance()
    {
        return new \wpdb('root', 'root', 'apovoice', '172.18.0.7');
    }

    public static function verifyConnection()
    {
        return self::instance()->ready;
    }
}