<?php

namespace apo\userroles\roles;

use awsm\wp\libraries\utilities\RoleBuilder;

class RegionalManagerSalesRepRole extends RoleBuilder 
{

    /**
     * Define if default capabilities are generated
     * this is usefull for custom post types with a custom capability type
     */
    protected $withDefaultCaps = false;

    /**
     * Define if capabilities are also removed from all other roles
     * this is usefull if you create unique capabilities for i.e. a custom post type
     */
    protected $removeCapsFromOtherRoles = false;

    /**
     * Define the new plugin specific role
     * @param role
     * @param displayName
     * @param textDomain
     */
    protected $role = [
        'regional_manager_sales_rep',
        'Regional Manager Sales Rep',
        'apo_user_roles',
    ];

    /**
     * Define caps for the new role
     * this array will be merged with all default custom post type capabilities 
     * if the $withDefaultCaps property is set to true
     * all caps are also assigned to the administrator
     */
    protected $capabilities = [
        'read' => true,
        'upload_files' => true,
        'read_reporting' => true,
    ];

    public function __construct($networkWide)
    {
        /**
         * Instantiate the RoleBuilder
         */
        parent::__construct($networkWide);   
    }

}