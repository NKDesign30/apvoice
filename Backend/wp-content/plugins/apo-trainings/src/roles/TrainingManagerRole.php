<?php

namespace apo\trng\roles;

use apo\trng\cpt\TrainingSeries;
use awsm\wp\libraries\utilities\RoleBuilder;

class TrainingManagerRole extends RoleBuilder 
{

    /**
     * Used to group the capabilities in one type
     * usefull for custom post types with a custom capability type
     */
    protected $capabilityTypeName = TrainingSeries::CAPABILITY_TYPE_NAME;

    /**
     * Define the new plugin specific role
     * @param role
     * @param displayName
     * @param textDomain
     */
    protected $role = [
        'training_manager',
        'Training Manager',
        'trng',
    ];

    /**
     * Define caps for the new role
     * this array will be merged with all default custom post type capabilities 
     * if the $withDefaultCaps property is set to true
     * all caps are also assigned to the administrator
     */
    protected $capabilities = [
        TrainingSeries::ACCESS_CAPABILITY => true,
    ];

    public function __construct($networkWide)
    {
        /**
         * Instantiate the RoleBuilder
         */
        parent::__construct($networkWide);   
    }

}