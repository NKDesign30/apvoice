<?php

namespace apo\reporting\jobs;

use apo\reporting\interfaces\Runable;

class StatisticsJobs implements Runable
{

    /**
     * Class name of job to be execute
     */
    protected $job;

    /**
     * Passed args to job class
     */
    protected $args;

	public function __construct() 
	{

    }

    public function run($job, ...$args)
    {
        $this->job = __NAMESPACE__ . '\\' . $job;
        $this->args = $args;

        if ( class_exists($this->job) ) {

            if ( is_multisite() ) {
                return $this->executeJobForMultisite();
            } else {
                return $this->execute();
            }

        } else {
            throw new \Exception("Passed class {$job} does not exists or does not match the given namespace of " . __NAMESPACE__);
        }
    }

    public function execute() 
    {  
        return (new $this->job(...$this->args))->dispatch();
    }

    public function executeJobForMultisite()
    {
        $results = [];
        foreach ( $this->getBlogIds() as $id ) {
            switch_to_blog( $id );
            $results[$id][] = $this->execute();
            restore_current_blog();
        }

        return $results;
    }

    protected function getBlogIds()
    {
        return array_map(function($blog) {
            return $blog->blog_id;
        }, get_sites());
    }


} 