<?php 

namespace apo\rxts\utilities;

use awsm\wp\libraries\utilities\AzureUploader;

class AzureRaffleUploader extends AzureUploader 
{
    public function __construct()
    {
        parent::__construct();

        $this->connectToRaffleContainer();

        return $this;
    }

    public function connectToRaffleContainer()
    {
        $this->toContainer(MICROSOFT_AZURE_RAFFLE_CONTAINER);
        return $this;
    }

    public static function getUrl($file)
    {
        return (new self)->getBlobUrl($file);
    }
}