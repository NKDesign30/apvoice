<?php 

namespace apo\reporting\utilities;

trait JobRolesTrait
{
    protected function pruneUnnecessaryJobRoles()
    {
        $statisticRoles = apo_get_job_roles();

        $this->jobRoles = $statisticRoles;

        return $this;
    }

    protected function getJobRoles()
    {
        return $this->jobRoles;
    }
}