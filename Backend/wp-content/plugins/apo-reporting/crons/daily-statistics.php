<?php 
use apo\reporting\jobs\StatisticsJobs;

try {
    return (new StatisticsJobs())->run('DailyStatistics', date('Y-m-d', strtotime('last day')));
} catch (\Exception $e) {
    $exception = 'Exception catched: ' .  $e->getMessage() . "\n";
    trigger_error($exception, E_USER_ERROR);
}
