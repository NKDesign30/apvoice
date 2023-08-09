<?php

namespace apo\pun\controllers;

use apo\pun\models\PUN;
use apo\pun\roles\PUNManagerRole;
use awsm\wp\libraries\utilities\RedirectBack;

class PUNBulkActionController
{

    use RedirectBack;

    /**
     * PUNBulkActionController constructor.
     */
    public function __construct()
    {
        $this->pun = new PUN();
    }

    /**
     * Handle an incoming POST request.
     */
    public function action()
    {
        if ( !current_user_can( PUNManagerRole::MANAGE_CAPABILITY ) ) {
            $this->redirectBack( ['errors' => [__( 'Your user role have not the necessary capability for this action', 'apo-pun' )]] );
        }

        if ( !$this->hasValidNonce() ) {
            $this->redirectBack( ['errors' => [__( 'Invalid nonce. Try re-submitting the form.', 'apo-pun' )]] );
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
        $ids = $_POST['puns'];
        $result = $this->pun->removeBulk($ids);

        $messages = [];

        if ( $result['removedPharmacies'] > 0 ) {
            $messages = ['infos' => [__( sprintf( '%d PUN\'s and %d Pharmarcy-User connections was removed.', $result['removedPharmacies'], $result['removedPharmacyUserConnection'] ), 'apo-pun' )]];
        }

        if ( count( $messages ) > 0 ) {
            $this->redirectBack( $messages );
        }

        $this->redirectBack( ['infos' => [__( 'Nothing was removed. Everything is up to date.', 'apo-pun' )]] );
    }

    /**
     * Check if the request has a valid nonce.
     *
     * @return bool
     */
    protected function hasValidNonce()
    {
        $nonce = $_POST['apo_pun_bulk_action_nonce'] ?? false;

        return wp_verify_nonce( wp_unslash( $nonce ), 'apo_pun_bulk_action' );
    }

}
