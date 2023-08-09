<?php

namespace apo\pgci\controllers;

use apo\pgci\models\PGCI;
use apo\pgci\roles\PGCIManagerRole;
use apo\pgci\parsers\ParserFactory;
use awsm\wp\libraries\utilities\UploadUtils;
use awsm\wp\libraries\utilities\RedirectBack;

class PGCIUploadController
{

    use UploadUtils, RedirectBack;

    /**
     * The uploaded file name from the input field
     */
    protected $file = 'apo_pgci_codes_file';

    /**
     * PGCIUploadController constructor.
     */
    public function __construct()
    {
        $this->pgci = new PGCI();
    }

    /**
     * Handle an incoming POST request.
     */
    public function update()
    {
        if ( !current_user_can( PGCIManagerRole::MANAGE_CAPABILITY ) ) {
            $this->redirectBack( ['errors' => [__( 'Your user role have not the necessary capability for this action', 'apo-pgci' )]] );
        }
        
        if ( !$this->hasValidNonce() ) {
            $this->redirectBack( ['errors' => [__( 'Invalid nonce. Try re-submitting the form.', 'apo-pgci' )]] );
        }

        if ( ( $message = $this->validateUploadedFile() ) !== true ) {
            $this->redirectBack( ['errors' => [$message]] );
        }

        header('Content-Type: text/plain');

        $values = $this->parseUploadedFile();

        if ( count($values) === 0 ) {
            $this->redirectBack( ['infos' => [__( 'No new PGCI\'s codes have been imported. Everything is up to date.', 'apo-pgci' )]] );
        }

        $countUpdated = 0;
        $countAdded = 0;

        foreach ($values as $item) {
            if ( $pgci = $this->pgci->exists($item['pg_customer_id']) ) {
                if($this->pgci->hasNameChanged($pgci->id, $item['name'])) {
                    $this->pgci->update(['name' => $item['name']], ['id' => $pgci->id]);
                    $countUpdated++;
                }
            } else {
                $this->pgci->create($item);
                $countAdded++;
            }
        }

        $messages = [];

        if ( $countAdded > 0 ) {
            $messages = ['infos' => [__( sprintf( '%d new PGCI\'s have been added.', $countAdded ), 'apo-pgci' )]];
        }

        if ( $countUpdated > 0 ) {
            $messages = array_merge( $messages, ['infos' => [__( sprintf( '%d PGCI\'s have been updated.', $countUpdated ), 'apo-pgci' )]] );
        }

        if ( count( $messages ) > 0 ) {
            $this->redirectBack( $messages );
        }

        $this->redirectBack( ['infos' => [__( 'No new PGCI\'s have been imported. Everything is up to date.', 'apo-pgci' )]] );
    }

    /**
     * Check if the request has a valid nonce.
     *
     * @return bool
     */
    protected function hasValidNonce()
    {
        $nonce = $_POST['apo_pgci_save_settings_nonce'] ?? false;

        return wp_verify_nonce( wp_unslash( $nonce ), 'apo_pgci_save_settings' );
    }

    /**
     * Parse the uploaded file from the request.
     *
     * @return array
     */
    protected function parseUploadedFile()
    {
        return ParserFactory::makeFromUpload( $_FILES[$this->file] )->parse();
    }

}
