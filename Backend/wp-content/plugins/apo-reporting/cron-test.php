<?php 
use apo\reporting\jobs\StatisticsJobs;

try {
    return (new StatisticsJobs())->run('DailyStatistics', date('Y-m-d', time()));
} catch (\Exception $e) {
    $exception = 'Exception catched: ' .  $e->getMessage() . "\n";
    trigger_error($exception, E_USER_ERROR);
}

/**
 * Use this code to reset the statistic data
 * set the date to the launch date
 */

// try {
//     return (new apo\reporting\jobs\StatisticsJobs())->run('DailyStatistics', date('Y-m-d', time()));
// } catch (\Exception $e) {
//     $exception = 'Exception catched: ' .  $e->getMessage() . "\n";
//     trigger_error($exception, E_USER_ERROR);
// }

/**
 * Use this to re-run the statistic date for a specific date
 * can run for a specific date range or for one date
 * 
 * Insert these following snippet into functions.php
 */

// function reinsert_statistic_data() {

//     if(isset($_GET['reporting'])) {

//         function createDateRange($startDate, $endDate) {
//             $start = new \DateTime( $startDate );
//             $end = new \DateTime( $endDate );
//             $end = $end->modify( '+1 day' );

//             $interval = new \DateInterval('P1D');
//             return new \DatePeriod($start, $interval ,$end);
//         }

//         /**
//          * if we have to have insert data for more than one date
//          */
//         // foreach (createDateRange('2019-11-01', '2020-01-20') as $date) {
//         //     try {
//         //         (new apo\reporting\jobs\StatisticsJobs())->run('DailyStatistics', $date->format('Y-m-d'));
//         //     } catch (\Exception $e) {
//         //         $exception = 'Exception catched: ' .  $e->getMessage() . "\n";
//         //         trigger_error($exception, E_USER_ERROR);
//         //     }
//         // }

//         /**
//          * if we have to have insert data for only one date
//          * */
//         // try {
//         //     return (new apo\reporting\jobs\StatisticsJobs())->run('DailyStatistics', date('Y-m-d', time()));
//         // } catch (\Exception $e) {
//         //     $exception = 'Exception catched: ' .  $e->getMessage() . "\n";
//         //     trigger_error($exception, E_USER_ERROR);
//         // }

//         echo "reporting data reinserted...";

//         die();
//     }
// }
// add_action( 'after_setup_theme', 'reinsert_statistic_data' );