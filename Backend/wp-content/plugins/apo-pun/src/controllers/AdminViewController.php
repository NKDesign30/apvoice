<?php

namespace apo\pun\controllers;

use apo\pun\models\PUN;
use apo\pun\roles\PUNManagerRole;
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
        $this->viewDirectory = APO_PUN_VIEWS_DIR;
        $this->pun = new PUN();

        $this->dateFormat = get_option( 'date_format' );
        $this->timeFormat = get_option( 'time_format' );
    }

    /**
     * Prepare the data for the PUN's admin view
     * 
     * @return template 
     */
    public function punCodes()
    {
        $data = [
            'puns' => $this->mapPUNs($this->pun->showByQueryParams($this->getQueryParams())),
            'payload' => $this->getPayload(),
            'messageClasses' => $this->getMessageClasses(),
            'can_manage' => current_user_can( PUNManagerRole::MANAGE_CAPABILITY ),
        ];

        return $this->view('pun-codes', $data);
    }

    private function mapPUNs($puns)
    {
        return array_map( function( $pun ) {

            $pun->created_at = $this->createDateTime($pun->created_at);

            return $pun;
        }, $puns);
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