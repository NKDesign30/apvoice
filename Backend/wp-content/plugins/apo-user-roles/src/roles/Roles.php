<?php

namespace apo\userroles\roles;

class Roles 
{

    protected $networkWide;

    /**
     * Register all role builder classes
     */
    protected $roles = [
        'apo\userroles\roles\PGAdminRole',
        'apo\userroles\roles\PGMemberRole',
        'apo\userroles\roles\DetailerRole',
        'apo\userroles\roles\SalesRepRole',
        'apo\userroles\roles\RegionalManagerDetailerRole',
        'apo\userroles\roles\RegionalManagerSalesRepRole',
        'apo\userroles\roles\HCPRole',
        'apo\userroles\roles\HCPWithout10EurRole',
        'apo\userroles\roles\BlockedRole',
    ];

    public function __construct($networkWide)
    {
        $this->networkWide = $networkWide;

        return $this;
    }

    public function create()
    {
        foreach ($this->roles as $role) {
            ( new $role( $this->networkWide ) )->create();
        }

        return $this;
    }

    public function remove()
    {
        foreach ($this->roles as $role) {
            ( new $role( $this->networkWide ) )->remove();
        }

        return $this;
    }

}