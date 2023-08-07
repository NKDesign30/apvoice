<?php 

namespace apo\reporting\utilities;

use apo\reporting\jobs\ReportingJob;

trait PruneUserRolesTrait
{
    protected function pruneUnnecessaryRoles()
    {
        $statisticRoles = ReportingJob::REPORTING_USER_ROLES;

        $this->roles = array_values(
            array_filter(array_keys(wp_roles()->roles), function($role) use ($statisticRoles) {
                return in_array($role, $statisticRoles);
            })
        );

        return $this;
    }

    protected function getRoles()
    {
        return $this->roles;
    }
}