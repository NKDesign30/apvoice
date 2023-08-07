<?php

namespace apo\expertcodes\roles;

use apo\expertcodes\roles\ExpertCodeManagerRole;
use awsm\wp\libraries\utilities\RoleBuilder;

class ExpertCodeSubscriberRole extends RoleBuilder 
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
        'expert_code_subscriber',
        'Expert Code Subscriber',
        'apovoice-expert-codes',
    ];

    /**
     * Define caps for the new role
     * this array will be merged with all default custom post type capabilities 
     * if the $withDefaultCaps property is set to true
     * all caps are also assigned to the administrator
     */
    protected $capabilities = [
        ExpertCodeManagerRole::ACCESS_CAPABILITY => true,
    ];

    public function __construct($networkWide)
    {
        /**
         * Instantiate the RoleBuilder
         */
        parent::__construct($networkWide);   
    }

}