<?php

namespace apo\pgci\roles;

use awsm\wp\libraries\utilities\RoleBuilder;

class PGCIManagerRole extends RoleBuilder 
{

    const ACCESS_CAPABILITY = 'read_gpcis';

    const MANAGE_CAPABILITY = 'manage_gpcis';

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
        'gpci_manager',
        'PGCI Manager',
        'apo-pgci',
    ];

    /**
     * Define caps for the new role
     * this array will be merged with all default custom post type capabilities 
     * if the $withDefaultCaps property is set to true
     * all caps are also assigned to the administrator
     */
    protected $capabilities = [
        self::ACCESS_CAPABILITY => true,
        self::MANAGE_CAPABILITY => true,
    ];

    public function __construct($networkWide)
    {
        /**
         * Instantiate the RoleBuilder
         */
        parent::__construct($networkWide);   
    }

}