<?php 

namespace apo\rxts\utilities;

use awsm\wp\libraries\utilities\AzureUploader;

class AzureProfileUploader extends AzureUploader 
{
    public function __construct()
    {
        parent::__construct();

        $this->connectToProfileContainer();

        return $this;
    }

    public function connectToProfileContainer()
    {
        $this->toContainer(MICROSOFT_AZURE_USER_PROFILE_CONTAINER);
        return $this;
    }

    public static function getUrl($file)
    {
        return (new self)->getBlobUrl($file);
    }
}