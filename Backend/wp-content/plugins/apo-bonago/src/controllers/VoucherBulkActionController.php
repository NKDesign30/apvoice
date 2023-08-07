<?php

namespace apo\bonago\controllers;

use apo\bonago\models\Voucher;
use apo\bonago\roles\BonagoVoucherManagerRole;
use awsm\wp\libraries\utilities\RedirectBack;

class VoucherBulkActionController
{

    use RedirectBack;

    /**
     * VoucherBulkActionController constructor.
     */
    public function __construct()
    {
        $this->voucher = new Voucher();
    }

    /**
     * Handle an incoming POST request.
     */
    public function action()
    {
        if ( !current_user_can( BonagoVoucherManagerRole::MANAGE_CAPABILITY ) ) {
            $this->redirectBack( ['errors' => [__( 'Your user role have not the necessary capability for this action', 'apo-pun' )]] );
        }

        if ( !$this->hasValidNonce() ) {
            $this->redirectBack( ['errors' => [__( 'Invalid nonce. Try re-submitting the form.', 'apovoice-bonago' )]] );
        }

        $method = $_POST['action_type'];

        if(method_exists($this, $method)) {
            $method = $_POST['action_type'];
            $this->$method();
        } else {
            $this->redirectBack();
        }
    }

    public function remove()
    {
        $ids = $_POST['vouchers'];
        $result = $this->voucher->removeBulk($ids);

        $messages = [];

        if ( $result > 0 ) {
            $messages = ['infos' => [__( sprintf( '%d voucher codes was removed.', $result ), 'apovoice-bonago' )]];
        }

        if ( count( $messages ) > 0 ) {
            $this->redirectBack( $messages );
        }

        $this->redirectBack( ['infos' => [__( 'Nothing was removed. Everything is up to date.', 'apovoice-bonago' )]] );
    }

    /**
     * Check if the request has a valid nonce.
     *
     * @return bool
     */
    protected function hasValidNonce()
    {
        $nonce = $_POST['apo_bonago_bulk_action_nonce'] ?? false;

        return wp_verify_nonce( wp_unslash( $nonce ), 'apo_bonago_bulk_action' );
    }

}
