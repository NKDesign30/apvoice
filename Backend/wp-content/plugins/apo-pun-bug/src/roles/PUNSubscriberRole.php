<?php

namespace apo\pun\roles;

use apo\pun\roles\PUNManagerRole;
use awsm\wp\libraries\utilities\RoleBuilder;

class PUNSubscriberRole extends RoleBuilder 
{

    /**
     * Used to group the capabilities in one type
     * usefull for custom post types with a custom capability type
     */
    protected $withDefaultCaps = false;

    /**
     * Define the new plugin specific role
     * @param role
     * @param displayName
     * @param textDomain
     */
    protected $role = [
        'pun_subscriber',
        'PUN Subscriber',
        'apo-pun',
    ];

    /**
     * Define caps for the new role
     * this array will be merged with all default custom post type capabilities 
     * if the $withDefaultCaps property is set to true
     * all caps are also assigned to the administrator
     */
    protected $capabilities = [
        PUNManagerRole::ACCESS_CAPABILITY => true,
    ];

    public function __construct($networkWide)
    {
        /**
         * Instantiate the RoleBuilder
         */
        parent::__construct($networkWide);   
    }

}