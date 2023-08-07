<?php

namespace apo\expertcodes\controllers;

use apo\expertcodes\roles\ExpertCodeManagerRole;
use awsm\wp\libraries\utilities\RedirectBack;

class ExpertCodesBulkActionController
{

    use RedirectBack;

    /**
     * Reference to the global $wpdb instance.
     *
     * @var wpdb
     */
    protected $wpdb;

    /**
     * ExpertCodesBulkActionController constructor.
     */
    public function __construct()
    {
        global $wpdb;

        $this->wpdb = $wpdb;
    }

    /**
     * Handle an incoming POST request.
     */
    public function action()
    {

        if ( !current_user_can( ExpertCodeManagerRole::MANAGE_CAPABILITY ) ) {
            $this->redirectBack( ['errors' => [__( 'Your user role have not the necessary capability for this action', 'apo-pun' )]] );
        }

        if ( !$this->hasValidNonce() ) {
            $this->redirectBack( ['errors' => [__( 'Invalid nonce. Try re-submitting the form.', 'apovoice-expert-codes' )]] );
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

        $countRemovedExpertCodes = 0;

        foreach ($_POST['expertCodes'] as $expertCode) {
            $removedExpertCodeId = $this->wpdb->delete( $this->wpdb->prefix . 'expert_codes', [ 'expert_code' => $expertCode ] );
            if($removedExpertCodeId > 0) {
                $countRemovedExpertCodes++;
            }
        }

        $messages = [];

        if ( $countRemovedExpertCodes > 0 ) {
            $messages = ['infos' => [__( sprintf( '%d expert codes was removed.', $countRemovedExpertCodes ), 'apovoice-expert-codes' )]];
        }

        if ( count( $messages ) > 0 ) {
            $this->redirectBack( $messages );
        }

        $this->redirectBack( ['infos' => [__( 'Nothing was removed. Everything is up to date.', 'apovoice-expert-codes' )]] );
    }

    /**
     * Check if the request has a valid nonce.
     *
     * @return bool
     */
    protected function hasValidNonce()
    {
        $nonce = $_POST['apo_expert_codes_bulk_action_nonce'] ?? false;

        return wp_verify_nonce( wp_unslash( $nonce ), 'apo_expert_codes_bulk_action' );
    }

}
