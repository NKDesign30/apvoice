<?php

namespace apo\migration\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;
use awsm\wp\libraries\utilities\RedirectBack;
use apo\migration\utilities\AzureMigrationFileUploader;

class MigrationDownloadController extends Controller
{

    use RedirectBack;
    
    public $usersMigration;

    public function __construct()
	{
        parent::__construct();
    }

    public function download()
    {
        if ( !$this->hasValidNonce() ) {
            $this->redirectBack( ['errors' => ['Invalid nonce. Try re-submitting the form.']] );
        }

        $downloadables = $_POST['apo-downloadables'];

        $results = [];
        if (!empty($downloadables) && !is_null($downloadables)) {
            foreach (explode(',', $downloadables) as $filePath) {
                preg_match('/\w+\.json/', $filePath, $fileName);
                $results[] = (new AzureMigrationFileUploader)->download( APO_MIGRATION_ASSETS . $filePath, $fileName[0]);
            }
        }

        $messages = [];

        if ($results) {
            $messages = ['infos' => ['Downloaded ' . sizeof(array_filter($results)) . '/' . sizeof($results) . ' Files from Azure Storage.']];
        }

        if ( count( $messages ) > 0 ) {
            $this->redirectBack( $messages );
        }

        $this->redirectBack( ['infos' => ['Nothing happened.']] );

    }


     /**
     * Check if the request has a valid nonce.
     *
     * @return bool
     */
    protected function hasValidNonce()
    {
        $nonce = $_POST['apo_migration_download_mapper_files_nonce'] ?? false;

        return wp_verify_nonce( wp_unslash( $nonce ), 'apo_migration_download_mapper_files' );
    }

} 
