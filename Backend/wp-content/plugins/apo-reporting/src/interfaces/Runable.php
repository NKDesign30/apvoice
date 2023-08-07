<?php 
namespace apo\reporting\interfaces;

interface Runable 
{
    public function run($job, ...$args);

    public function execute();

    public function executeJobForMultisite();
}