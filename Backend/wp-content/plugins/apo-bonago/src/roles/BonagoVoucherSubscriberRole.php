<?php

namespace apo\bonago\roles;

use apo\bonago\roles\BonagoVoucherManagerRole;
use awsm\wp\libraries\utilities\RoleBuilder;

class BonagoVoucherSubscriberRole extends RoleBuilder 
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
        'bonago_voucher_subscriber',
        'Bonago Voucher Subscriber',
        'apovoice-bonago',
    ];

    /**
     * Define caps for the new role
     * this array will be merged with all default custom post type capabilities 
     * if the $withDefaultCaps property is set to true
     * all caps are also assigned to the administrator
     */
    protected $capabilities = [
        BonagoVoucherManagerRole::ACCESS_CAPABILITY => true,
    ];

    public function __construct($networkWide)
    {
        /**
         * Instantiate the RoleBuilder
         */
        parent::__construct($networkWide);   
    }

}