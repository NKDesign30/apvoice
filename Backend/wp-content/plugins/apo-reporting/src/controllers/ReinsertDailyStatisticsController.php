<?php

namespace apo\reporting\controllers;

use apo\reporting\jobs\StatisticsJobs;
use awsm\wp\libraries\utilities\RedirectBack;

class ReinsertDailyStatisticsController
{

    use RedirectBack;

    /**
     * ReinsertDailyStatisticsController constructor.
     */
    public function __construct()
    {

    }

    /**
     * Handle an incoming POST request.
     */
    public function store()
    {
        $startDate = $_POST['apo_reporting_reinsert_daily_statistics_start_date'];
        $endDate = $_POST['apo_reporting_reinsert_daily_statistics_end_date'];

        if ( !current_user_can( 'reinsert_reporting_statistics' ) ) {
            $this->redirectBack( ['errors' => [__( 'Your user role have not the necessary capability for this action', 'apo_reporting' )]] );
        }
        
        if ( !$this->hasValidNonce() ) {
            $this->redirectBack( ['errors' => [__( 'Invalid nonce. Try re-submitting the form.', 'apo_reporting' )]] );
        }

        if ( !$this->validateDate($startDate) ) {
            $this->redirectBack( ['errors' => [__( 'Start date has an invalid format.', 'apo_reporting' )]] );
        }

        if ( !$this->validateDate($endDate) ) {
            $this->redirectBack( ['errors' => [__( 'End date has an invalid format.', 'apo_reporting' )]] );
        }

        if ( $startDate > $endDate) {
            $this->redirectBack( ['errors' => [__( 'End date must be in the future or at least the same as start date.', 'apo_reporting' )]] );
        }

        if ( $startDate < REPORTING_INITIAL_START_DATE) {
            $this->redirectBack( ['errors' => [__( 'Start date can not be before the initial reporting date of ' . REPORTING_INITIAL_START_DATE, 'apo_reporting' )]] );
        }

        if ( $endDate > date('Y-m-d', time())) {
            $this->redirectBack( ['errors' => [__( 'End date can not be in the future', 'apo_reporting' )]] );
        }

        $this->reinsertDailyStatistics($startDate, $endDate);

        $this->redirectBack( ['infos' => [__( "Daily Statistics are successfully re-inserted from {$startDate} to {$endDate}", 'apo_reporting' )]] );
    }

    /**
     * Check if the request has a valid nonce.
     *
     * @return bool
     */
    protected function hasValidNonce()
    {
        $nonce = $_POST['apo_reporting_reinsert_daily_statistics_nonce'] ?? false;

        return wp_verify_nonce( wp_unslash( $nonce ), 'apo_reporting_reinsert_daily_statistics' );
    }

    /**
     * Check if its a valid date
     * 
     * @return bool
     */
    protected function validateDate($date)
    {
        $tempDate = explode('-', $date);
        return checkdate($tempDate[1], $tempDate[2], $tempDate[0]);
    }

    /**
     * Reinsert daily statistics
     * 
     * @return void 
     */
    protected function reinsertDailyStatistics($startDate, $endDate)
    {
        foreach ($this->createDateRange($startDate, $endDate) as $date) {
            try {
                (new StatisticsJobs())->run('DailyStatistics', $date->format('Y-m-d'));
            } catch (\Exception $e) {
                $exception = 'Exception catched: ' .  $e->getMessage() . "\n";
                trigger_error($exception, E_USER_ERROR);
            }
        }
    }

    /**
     * Create daterange
     * 
     * @param datesring $startDate
     * @param datesring $endDate
     * 
     * @return \DatePeriod
     */
    protected function createDateRange($startDate, $endDate) {
        $start = new \DateTime( $startDate );
        $end = new \DateTime( $endDate );
        $end = $end->modify( '+1 day' );

        $interval = new \DateInterval('P1D');
        return new \DatePeriod($start, $interval ,$end);
    }
}
