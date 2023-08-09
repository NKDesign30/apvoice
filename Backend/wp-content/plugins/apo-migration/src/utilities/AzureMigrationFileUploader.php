<?php 

namespace apo\migration\utilities;

use awsm\wp\libraries\utilities\AzureUploader;

class AzureMigrationFileUploader extends AzureUploader 
{
    public function __construct()
    {
        parent::__construct();

        $this->connectToMigrationContainer();

        return $this;
    }

    public function connectToMigrationContainer()
    {
        $this->toContainer('migration');
        return $this;
    }

    public static function getUrl($file)
    {
        return (new self)->getBlobUrl($file);
    }
}