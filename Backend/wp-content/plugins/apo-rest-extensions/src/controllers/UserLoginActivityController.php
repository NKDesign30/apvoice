<?php

namespace apo\rxts\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;
use awsm\wp\libraries\utilities\Auth;

class UserLoginActivityController extends Controller
{

    use Auth;

	public function __construct()
	{
        parent::__construct();
    }

    public function show( $object ) {
        $loginDates = maybe_unserialize( get_user_meta( $this->userId(), 'login_dates', true) );

        rsort($loginDates, SORT_NUMERIC );
        array_shift($loginDates);

        if (!$loginDates[0]) return 100;
        
        return $this->getLoginActivity($loginDates[0]);
    }

    protected function getLoginActivity($lastLogin)
    {
        $currentDate = time();
        $last24h = strtotime('-1 day', $currentDate);
        $last48h = strtotime('-2 day', $currentDate);
        $lastWeek = strtotime('-1 week', $currentDate);
        $lastTwoWeeks = strtotime('-2 week', $currentDate);

            switch (true) {
                case $lastLogin >= $last24h;
                return 100;
                
                case $lastLogin >= $last48h;
                return 75;
            
                case $lastLogin >= $lastWeek;
                return 50;
            
                case $lastLogin - $lastTwoWeeks >= 0;
                return 25;
            
                default:
                    return 0;
            }
    }
}
