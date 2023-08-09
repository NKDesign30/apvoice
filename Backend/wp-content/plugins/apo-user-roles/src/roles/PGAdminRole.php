<?php

namespace apo\userroles\roles;

use awsm\wp\libraries\utilities\RoleBuilder;

class PGAdminRole extends RoleBuilder 
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
        'pg_admin',
        'P&G Admin',
        'apo_user_roles',
    ];

    /**
     * Define caps for the new role
     * this array will be merged with all default custom post type capabilities 
     * if the $withDefaultCaps property is set to true
     * all caps are also assigned to the administrator
     */
    protected $capabilities = [
        'edit_trainings' => true,
        'edit_others_trainings' => true,
        'publish_trainings' => true,
        'read_private_trainings' => true,
        'gravityforms_view_entries' => true,
        'edit_surveys' => true,
        'edit_others_surveys' => true,
        'publish_surveys' => true,
        'read_private_surveys' => true,
        'edit_posts' => true,
        'edit_others_posts' => true,
        'publish_posts' => true,
        'read_private_posts' => true,
        'read' => true,
        'delete_posts' => true,
        'delete_private_posts' => true,
        'delete_published_posts' => true,
        'delete_others_posts' => true,
        'edit_private_posts' => true,
        'edit_published_posts' => true,
        'edit_detailersjobs' => true,
        'edit_others_detailersjobs' => true,
        'publish_detailersjobs' => true,
        'read_private_detailersjobs' => true,
        'publish_blocks' => true,
        'read_private_blocks' => true,
        'delete_blocks' => true,
        'delete_private_blocks' => true,
        'edit_private_blocks' => true,
        'upload_files' => true,
        'edit_pages' => true,
        'edit_others_pages' => true,
        'publish_pages' => true,
        'read_private_pages' => true,
        'delete_pages' => true,
        'delete_private_pages' => true,
        'delete_published_pages' => true,
        'delete_others_pages' => true,
        'edit_private_pages' => true,
        'edit_published_pages' => true,
        'create_users' => true,
        'delete_users' => true,
        'edit_users' => true,
        'list_roles' => true,
        'list_users' => true,
        'delete_detailersjob' => true,
        'delete_detailersjobs' => true,
        'delete_others_detailersjobs' => true,
        'delete_others_surveys' => true,
        'delete_others_trainings' => true,
        'delete_private_detailersjobs' => true,
        'delete_private_surveys' => true,
        'delete_private_trainings' => true,
        'delete_published_detailersjobs' => true,
        'delete_published_surveys' => true,
        'delete_published_trainings' => true,
        'delete_survey' => true,
        'delete_surveys' => true,
        'delete_training' => true,
        'delete_trainings' => true,
        'edit_detailersjob' => true,
        'edit_private_detailersjobs' => true,
        'edit_private_surveys' => true,
        'edit_private_trainings' => true,
        'edit_published_detailersjobs' => true,
        'edit_published_surveys' => true,
        'edit_published_trainings' => true,
        'edit_survey' => true,
        'edit_training' => true,
        'manage_detailers_job' => true,
        'manage_surveys' => true,
        'manage_trainings' => true,
        'read_bonago_vouchers' => true,
        'read_detailersjob' => true,
        'read_expert_codes' => true,
        'read_puns' => true,
        'read_survey' => true,
        'read_training' => true,
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