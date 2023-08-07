<?php 

namespace apo\migration\utilities;

use apo\migration\utilities\AzureMigrationFileUploader;

trait UploadTrait {

    public function upload()
    {
        if( !method_exists($this, 'getFilePathsFromCreateMode') ) {
            return 'Method getFilePathsFromCreateMode() does not exists';
        }
        $results = [];
        foreach ($filePathsFromCreateMod = $this->getFilePathsFromCreateMode() as $filePath) {
            preg_match('/\w+\.json/', $filePath, $fileName);
            if(file_exists($filePath) && $fileName[0] ) {
                $results[] = (new AzureMigrationFileUploader())->upload($filePath, $fileName[0]);
            }
        }

        return "Uploaded " . sizeof(array_filter($results)) . "/" . sizeof($filePathsFromCreateMod) . " Files";
    }
}