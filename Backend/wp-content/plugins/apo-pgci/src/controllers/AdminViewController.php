<?php

namespace apo\pgci\controllers;

use apo\pgci\models\PGCI;
use apo\pgci\roles\PGCIManagerRole;
use awsm\wp\libraries\Controller;

class AdminViewController extends Controller
{

    /**
     * The date format from the WordPress backend
     */
    protected $dateFormat;

    /**
     * The time format from the WordPress backend
     */
    protected $timeFormat;

    public function __construct()
    {
        parent::__construct();
        $this->viewDirectory = APO_PGCI_VIEWS_DIR;
        $this->pgci = new PGCI();

        $this->dateFormat = get_option( 'date_format' );
        $this->timeFormat = get_option( 'time_format' );
    }

    /**
     * Prepare the data for the PGCI's admin view
     *
     * @return template
     */
    public function pgciCodes()
    {
        $data = [
            'pgcis' => $this->mapPGCIs($this->pgci->showByQueryParams($this->getQueryParams())),
            'payload' => $this->getPayload(),
            'messageClasses' => $this->getMessageClasses(),
            'can_manage' => current_user_can( PGCIManagerRole::MANAGE_CAPABILITY ),
        ];

        return $this->view('pgci-codes', $data);
    }

    private function mapPGCIs($pgcis)
    {
        return array_map( function( $pgci ) {

            $pgci->created_at = $this->createDateTime($pgci->created_at);

            return $pgci;
        }, $pgcis);
    }

    private function createDate($date)
    {
        if(is_null($date)) return;

        return date_i18n( $this->dateFormat, strtotime( $date ) );
    }

    private function createTime($time)
    {
        if(is_null($time)) return;

        return date_i18n( $this->timeFormat, strtotime( $time ) );
    }

    private function createDateTime($date)
    {
        if(is_null($date)) return;
        return "{$this->createDate($date)} {$this->createTime($date)}";
    }

    private function getQueryParams()
    {
        return [
            's' => $this->getSearchParam(),
        ];
    }

    private function getSearchParam()
    {
        return $_GET['s'] ?? null;
    }

    private function getPayload()
    {
        $payload = unserialize( base64_decode( $_GET['payload'] ?? '' ) );
        return $payload ? $payload : [];
    }

    private function getMessageClasses()
    {
        return [
            'infos' => 'updated notice',
            'errors' => 'error notice',
            'notices' => 'update-nag notice',
        ];
    }

}
