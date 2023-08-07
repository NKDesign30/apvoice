<?php

namespace apo\bonago\controllers;

use apo\bonago\models\Voucher;
use apo\bonago\parsers\ParserFactory;
use awsm\wp\libraries\utilities\UploadUtils;
use awsm\wp\libraries\utilities\RedirectBack;
use apo\bonago\roles\BonagoVoucherManagerRole;

class VoucherUploadController
{

    use UploadUtils, RedirectBack;

    /**
     * The uploaded file name from the input field
     */
    protected $file = 'apo_bonago_voucher_codes_file';

    /**
     * VoucherUploadController constructor.
     */
    public function __construct()
    {
        $this->voucher = new Voucher();
    }

    /**
     * Handle an incoming POST request.
     */
    public function update()
    {
        if ( !current_user_can( BonagoVoucherManagerRole::MANAGE_CAPABILITY ) ) {
            $this->redirectBack( ['errors' => [__( 'Your user role have not the necessary capability for this action', 'apo-pun' )]] );
        }
        
        if ( !$this->hasValidNonce() ) {
            $this->redirectBack( ['errors' => [__( 'Invalid nonce. Try re-submitting the form.', 'apovoice-bonago' )]] );
        }

        if ( ( $message = $this->validateUploadedFile() ) !== true ) {
            $this->redirectBack( ['errors' => [$message]] );
        }

        header('Content-Type: text/plain');

        $values = $this->parseUploadedFile();

        $this->formatExpiresAtDates($values);

        if ( count($values) === 0 ) {
            $this->redirectBack( ['infos' => [__( 'No new voucher codes have been imported. Everything is up to date.', 'apovoice-bonago' )]] );
        }

        $countUpdated = 0;
        $countAdded = 0;
        foreach ($values as $item) {
            if ( $voucher = $this->voucher->exists($item['voucher_code']) ) {
                if($this->voucher->hasExpiresAtDateChanged($voucher->id, $item['expires_at'])) {
                    $this->voucher->update(['expires_at' => $item['expires_at']], ['id' => $voucher->id]);
                    $countUpdated++;
                }
            } else {
                $this->voucher->create($item);
                $countAdded++;
            }
        }

        $messages = [];

        if ( $countAdded > 0 ) {
            $messages = ['infos' => [__( sprintf( '%d new voucher codes have been added.', $countAdded ), 'apovoice-bonago' )]];
        }

        if ( $countUpdated > 0 ) {
            $messages = array_merge( $messages, ['infos' => [__( sprintf( '%d voucher codes have been updated.', $countUpdated ), 'apovoice-bonago' )]] );
        }

        if ( count( $messages ) > 0 ) {
            $this->redirectBack( $messages );
        }

        $this->redirectBack( ['infos' => [__( 'No new voucher codes have been imported. Everything is up to date.', 'apovoice-bonago' )]] );
    }

    /**
     * Check if the request has a valid nonce.
     *
     * @return bool
     */
    protected function hasValidNonce()
    {
        $nonce = $_POST['apo_bonago_voucher_codes_file_save_settings_nonce'] ?? false;

        return wp_verify_nonce( wp_unslash( $nonce ), 'apo_bonago_voucher_codes_file_save_settings' );
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

    /**
     * Make sure that the expires_at date has the right format
     * 
     * @return void
     */
    protected function formatExpiresAtDates(&$items)
    {
        $items = array_map(function($item) {
            $item['expires_at'] = date("Y-m-d", strtotime($item['expires_at']));
            return $item;
        }, $items);
    }
}
