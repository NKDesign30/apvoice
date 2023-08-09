<?php

namespace apo\migration\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;
use awsm\wp\libraries\utilities\RedirectBack;

class MigrationController extends Controller
{

    use RedirectBack;
    
    public $usersMigration;

    public function __construct()
	{
        parent::__construct();
    }

    public function handle()
    {
        if ( !$this->hasValidNonce() ) {
            $this->redirectBack( ['errors' => ['Invalid nonce. Try re-submitting the form.']] );
        }

        $class =  __NAMESPACE__ . '\\migration\\' . $_POST['apo-migration-class'];
        $method = $_POST['apo-migration-method'];

        if ( !class_exists($class) || !method_exists( $class, $method ) ) {
            $this->redirectBack( ['errors' => ['Your choosen migration process does not exists. ' . $class . '@' . $method . ' not found.']] );
        }

        $messages = [];
        $result = (new $class)->$method();

        if ($result) {
            $messages = ['infos' => [$result]];
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
        $nonce = $_POST['apo_migration_process_merge_nonce'] ?? false;

        return wp_verify_nonce( wp_unslash( $nonce ), 'apo_migration_process_merge' );
    }

} 
