<?php 

namespace awsm\wp\libraries\utilities;

use Exception;
use Mimey\MimeTypes;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions;

class AzureUploader 
{
    protected $client;

    protected $accountName;

    protected $accountKey;

    protected $containerName;

    public function __construct($accountName = null, $accountKey = null) 
    {
        if( is_null( $accountName) ) {
            $this->setPreconfiguratedAccountName();
        } else {
            $this->accountName = $accountName;
        }

        if( is_null( $accountKey) ) {
            $this->setPreconfiguratedAccountKey();
        } else {
            $this->accountKey = $accountKey;
        }

        if( !$this->accountName || !$this->accountKey) {
            $this->invalidCredentialsException();
        }

        $this->createClient();

        return $this;
    }

    static public function getAccountName() {
		return defined( 'MICROSOFT_AZURE_ACCOUNT_NAME' )
			? MICROSOFT_AZURE_ACCOUNT_NAME
			: get_option( 'azure_storage_account_name' );
    }
    
	static public function getAccountKey() {
		return defined( 'MICROSOFT_AZURE_ACCOUNT_KEY' )
			? MICROSOFT_AZURE_ACCOUNT_KEY
			: get_option( 'azure_storage_account_primary_access_key' );
	}

    public function toContainer($containerName)
    {
        if( !$containerName ) {
            $this->invalidContainerException();
        }
        $this->containerName = $containerName;
        return $this;
    }

    public function upload($blob, $name)
    {
        $file = @fopen($blob, "r");

        if ( $file ) {

            
            $options = new CreateBlockBlobOptions();
            $mime = NULL;
            
            try {
                // identify mime type
                $mimes = new MimeTypes;
                $mime = $mimes->getMimeType(pathinfo($name, PATHINFO_EXTENSION));
                // set content type
                $options->setContentType($mime);
            } catch ( Exception $e ) {
                error_log("Failed to read mime from '{$blob}': {$e}");
            } 
            
            try {
                if( $mime ) {
                    $cacheTime = $this->getCacheTimeByMimeType($mime);
                    if( $cacheTime ) {
                        $options->setCacheControl("public, max-age=".$cacheTime);
                    }
                }
    
                $this->client->createBlockBlob($this->containerName, $name, $file, $options);
            } catch ( Exception $e ) {
                return "Failed to upload file";
                error_log("Failed to upload file '".$file."' to storage: ". $e);
            } 

            @fclose($file);
            return true;
        } else {
            return "Failed to open file";
            error_log("Failed to open file '{$blob}' to upload to storage.");
            return false;
        }
    }

    public function destroy($name)
    {
        try {
            $this->client->deleteBlob($this->containerName, $name);
        } catch ( Exception $e ) {
            error_log("Failed to delete file '{$name}' from storage");
            return false;
        } 
    
        return true;
    }

    public function blobExists($name)
    {
        try {
            return (bool) $this->client->getBlob($this->containerName, $name);
        } catch ( Exception $e ) {
            error_log("The file '{$name}' does not exists in storage");
            return false;
        } 
    }

    public function getBlobUrl($name)
    {
        if ($this->blobExists($name)) {
            return $this->client->getBlobUrl($this->containerName, $name);
        }
        return null;
    }

    public function download($path, $name)
    {
        if ($this->blobExists($name)) {
            return $this->client->saveBlobToFile($path, $this->containerName, $name);
        }
        return null;
    }

    protected function getCacheTimeByMimeType($mime)
    {  
        $mime = strtolower($mime);

        $types = array(
            "application/json" => 604800,// 7 days
            "application/javascript" => 604800,// 7 days
            "application/xml" => 604800,// 7 days
            "application/xhtml+xml" => 604800,// 7 days
            "image/bmp" => 604800,// 7 days
            "image/gif" => 604800,// 7 days
            "image/jpeg" => 604800,// 7 days
            "image/png" => 604800,// 7 days
            "image/tiff" => 604800,// 7 days
            "image/svg+xml" => 604800,// 7 days
            "image/x-icon" => 604800,// 7 days
            "text/plain" => 604800, // 7 days
            "text/html" => 604800,// 7 days
            "text/css" => 604800,// 7 days
            "text/richtext" => 604800,// 7 days
            "text/xml" => 604800,// 7 days
        );

        // return value
        if(array_key_exists($mime, $types))
        {
            return $types[$mime];
        }

        return FALSE;
    }

    protected function setPreconfiguratedAccountName()
    {
        $this->accountName = self::getAccountName();
        return $this;
    }


    protected function setPreconfiguratedAccountKey()
    {
        $this->accountKey = self::getAccountKey();
    }

    protected function createClient()
    {
        $connectionString = "DefaultEndpointsProtocol=https;AccountName={$this->accountName};AccountKey={$this->accountKey}";
        $this->client = BlobRestProxy::createBlobService($connectionString);
        return $this;
    }

    private function invalidCredentialsException()
    {
        throw new Exception('Invalid Microsoft Azure storage credentials. You must define the "MICROSOFT_AZURE_ACCOUNT_NAME" and "MICROSOFT_AZURE_ACCOUNT_KEY" constants');
    }

    private function invalidContainerException()
    {
        throw new Exception('Invalid Microsoft Azure storage container. You must provide a container name');
    }
}