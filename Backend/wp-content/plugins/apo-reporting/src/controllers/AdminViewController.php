<?php

namespace apo\reporting\controllers;

use awsm\wp\libraries\Controller;
use apo\reporting\models\DailyStatsPerSalesRep;

class AdminViewController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->viewDirectory = APO_REPORTING_VIEWS_DIR;
    }

    /**
     * Prepare the data for the bonago vouchers admin view
     * 
     * @return template 
     */
    public function reporting()
    {

        return $this->view('reporting');
    }

    public function settings()
    {
        $data = [
            'payload' => $this->getPayload(),
            'messageClasses' => $this->getMessageClasses(),
        ];

        return $this->view('settings', $data);
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