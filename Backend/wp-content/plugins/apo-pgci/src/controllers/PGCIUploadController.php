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
         $i=0;
        $duplicated_bga=0 ;
        foreach ($values as $item) {
            if($i==0){
                $i++;  
                continue;  
            }
          if ( $pgci = $this->pgci->exists($item['id']) ) {
                $test=0;

                if($this->pgci->hasNameChanged($pgci->id, $item['name'])) {
                    $this->pgci->update(['name' => $item['name']], ['id' => $pgci->id]);
                    $test=1;
                }

                if($this->pgci->hasBgaChanged($pgci->id, $item['bga_id'])) {
                    $this->pgci->update(['bga_id' => $item['bga_id']], ['id' => $pgci->id]);
                    $test=1;
                }

                if($this->pgci->hasStreetChanged($pgci->id, $item['street'])) {
                    $this->pgci->update(['street' => $item['street']], ['id' => $pgci->id]);
                    $test=1;
                }

                if($this->pgci->hasHouseNrhanged($pgci->id, $item['house_nr'])) {
                    $this->pgci->update(['house_nr' => $item['house_nr']], ['id' => $pgci->id]);
                    $test=1;
                }

                if($this->pgci->hasZipCodehanged($pgci->id, $item['zip_code'])) {
                    $this->pgci->update(['zip_code' => $item['zip_code']], ['id' => $pgci->id]);
                    $test=1;
                }

                if($this->pgci->hasCityhanged($pgci->id, $item['city'])) {
                    $this->pgci->update(['city' => $item['city']], ['id' => $pgci->id]);
                    $test=1;
                }

                //check if any field has been updated
                if($test=1){
                    $countUpdated++;
                }

            } else {
                if(!$this->pgci->existsBga($item['bga_id'])){
                    $this->pgci->create($item);
                    $countAdded++;
                }else{
                    $duplicated_bga++;
                }
            }

          
            
            
           


        }

        $messages = [];

        if ( $countAdded > 0 ) {
            $messages = ['infos' => [__( sprintf( '%d new PGCI\'s have been added.', $countAdded ), 'apo-pgci' )]];
        }

        if ( $countUpdated > 0 ) {
            $messages = array_merge( $messages, ['infos' => [__( sprintf( '%d PGCI\'s have been updated.', $countUpdated ), 'apo-pgci' )]] );
        }

        if ( $duplicated_bga > 0 ) {
            if($duplicated_bga<=1){
                $messages = array_merge( $messages, ['notices' => [__( sprintf( $duplicated_bga .' Row has not been imported due to bga_id duplication', $duplicated_bga ), 'apo-pgci' )]] );
            }else{
                $messages = array_merge( $messages, ['notices' => [__( sprintf( $duplicated_bga .' Rows has not been imported due to bga_id duplication', $duplicated_bga ), 'apo-pgci' )]] );
            }
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
