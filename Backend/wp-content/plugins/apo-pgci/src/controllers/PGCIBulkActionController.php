<?php

namespace apo\pgci\controllers;

use apo\pgci\models\PGCI;
use apo\pgci\roles\PGCIManagerRole;
use awsm\wp\libraries\utilities\RedirectBack;

class PGCIBulkActionController
{

    use RedirectBack;

    /**
     * PGCIBulkActionController constructor.
     */
    public function __construct()
    {
        $this->pgci = new PGCI();
    }

    /**
     * Handle an incoming POST request.
     */
    public function action()
    {
        if ( !current_user_can( PGCIManagerRole::MANAGE_CAPABILITY ) ) {
            $this->redirectBack( ['errors' => [__( 'Your user role have not the necessary capability for this action', 'apo-pgci' )]] );
        }

        if ( !$this->hasValidNonce() ) {
            $this->redirectBack( ['errors' => [__( 'Invalid nonce. Try re-submitting the form.', 'apo-pgci' )]] );
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
        $ids = $_POST['pgcis'];
        $result = $this->pgci->removeBulk($ids);

        $messages = [];

        if ( $result['removedPharmacies'] > 0 ) {
            $messages = ['infos' => [__( sprintf( '%d PGCI\'s and %d Pharmarcy-User connections was removed.', $result['removedPharmacies'], $result['removedPharmacyUserConnection'] ), 'apo-pgci' )]];
        }

        if ( count( $messages ) > 0 ) {
            $this->redirectBack( $messages );
        }

        $this->redirectBack( ['infos' => [__( 'Nothing was removed. Everything is up to date.', 'apo-pgci' )]] );
    }

    /**
     * Check if the request has a valid nonce.
     *
     * @return bool
     */
    protected function hasValidNonce()
    {
        $nonce = $_POST['apo_pgci_bulk_action_nonce'] ?? false;

        return wp_verify_nonce( wp_unslash( $nonce ), 'apo_pgci_bulk_action' );
    }

}
