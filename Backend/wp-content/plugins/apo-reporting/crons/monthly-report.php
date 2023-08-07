<?php 
use apo\reporting\jobs\StatisticsJobs;
use apo\reporting\jobs\types\Report;

try { 
    return (new StatisticsJobs())->run('ReportingJob', Report::MONTHLY);
} catch (\Exception $e) {
    $exception = 'Exception catched: ' .  $e->getMessage() . "\n";
    trigger_error($exception, E_USER_ERROR);
}
