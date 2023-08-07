<?php

namespace awsm\wp\libraries\utilities;

use Exception;

class RoleBuilder
{   

    /**
     * Define if role and capabilities should be created 
     * for all sites in a multisite network
     */
    protected $networkWide = true;

    /**
     * Define if default capabilities are generated
     * this is usefull for custom post types with a custom capability type
     */
    protected $withDefaultCaps = true;

    /**
     * Define if capabilities are also removed from all other roles
     * this is usefull if you create unique capabilities for i.e. a custom post type
     */
    protected $removeCapsFromOtherRoles = true;

    /**
     * Used to group the capabilities in one type
     * usefull for custom post types with a custom capability type
     */
    protected $capabilityTypeName;
    
    /**
     * Define the new plugin specific role
     * @param role
     * @param displayName
     * @param textDomain
     */
    protected $role = [];

    /**
     * Define caps for the new role
     * this array will be merged with all default custom post type capabilities 
     * if the $withDefaultCaps property is set to true
     * all caps are also assigned to the administrator
     */
    protected $capabilities = [];

    /**
     * Defines the serach and replace placeholder
     */
    private $placeholder = '##CAPABILITY_TYPE##';

    /**
     * WordPress's administartor role slug
     */
    private $administrator = 'administrator';

    /**
     * Instantiate the RoleBuilder
     */
    public function __construct($networkWide = true)
    {
        $this->networkWide = $networkWide;
    }

    /**
     * Creates the new role with defined capabilities
     */
    public function create()
    {
        if ( empty ($this->role) ) {
            throw new Exception('The role array must be provided with 3 entries. Required are: rolename, displayname, textdomain');
        }

        if ( $this->withDefaultCaps && empty ($this->capabilityTypeName) ) {
            throw new Exception('A capability type name must be provied');
        }

        if ( $this->withDefaultCaps ) {
            $this->addDefaultCaps();
        }
  
        if( is_multisite() && $this->networkWide ) {
            $this->storeForMultisite();
        } else {
            $this->store();
        }

        return $this;
    }

    /**
     * Removes all created and assigned roles and capabilities
     */
    public function remove()
    {
        if ( $this->withDefaultCaps ) {
            $this->addDefaultCaps();
        }

        if( is_multisite() && $this->networkWide ) {
            $this->destroyForMultisite();
        } else {
            $this->destroy();
        }

        return $this;
    }

    /**
     * Stores role and capabilities
     */
    protected function store()
    {
        $this->addRole()
            ->assignCapsToAdministrator();
        
        return $this;
    }

    /**
     * Iterates over each blog and call the store() method
     */
    protected function storeForMultisite()
    {
        foreach ( $this->getBlogIds() as $id ) {
            switch_to_blog( $id );
            $this->store();
            restore_current_blog();
        }
        return $this;
    }

    /**
     * Destroy role and capabilities
     */
    protected function destroy()
    {
        [ $role ] = $this->role;

        if( get_role( $role ) ) {
            remove_role( $role );
        }

        if ( $this->removeCapsFromOtherRoles ) {
            global $wp_roles;

            foreach ($this->capabilities as $cap => $grant) {
                foreach (array_keys($wp_roles->roles) as $role) {
                    get_role( $role )->remove_cap($cap);
                }
            } 
        }         
    }

    /**
     * Iterates over each blog and call the destroy() method
     */
    protected function destroyForMultisite()
    {
        foreach ( $this->getBlogIds() as $id ) {
            switch_to_blog( $id );
            $this->destroy();
            restore_current_blog();
        }
        return $this;
    }

    /**
     * Add the new role with defined capabilities
     */
    protected function addRole()
    {
        [ $role, $displayName, $textDomain ] = $this->role;
    
        add_role( $role, __( $displayName, $textDomain), $this->capabilities);

        return $this;
    }

    /**
     * Assign all defined capabilities to the administrator role
     */
    protected function assignCapsToAdministrator()
    {
        if ( empty ( $this->capabilities ) ) return $this;

        $admin = get_role( $this->administrator );

        foreach ($this->capabilities as $cap => $grant) {
            $admin->add_cap( $cap, $grant );
        }   

        return $this;
    }

    /**
     * Generate all defaul capabilities for a custom post type
     */
    protected function addDefaultCaps()
    {
        $capabilitiesBlueprint = [
            "edit_{$this->placeholder}" => true,
            "read_{$this->placeholder}" => true,
            "delete_{$this->placeholder}" => true,
            "edit_{$this->placeholder}s" => true,
            "edit_published_{$this->placeholder}s" => true,
            "edit_others_{$this->placeholder}s" => true,
            "edit_private_{$this->placeholder}s" => true,
            "read_private_{$this->placeholder}s" => true,
            "publish_{$this->placeholder}s" => true,
            "delete_{$this->placeholder}s" => true,
            "delete_published_{$this->placeholder}s" => true,
            "delete_others_{$this->placeholder}s" => true,
            "delete_private_{$this->placeholder}s" => true,
        ];


        foreach ($capabilitiesBlueprint as $cap => $grant) {
            $capabilities[ str_replace($this->placeholder, $this->capabilityTypeName, $cap) ] = $grant;
       }

        $this->capabilities = array_merge($capabilities, $this->capabilities);

        return $this;
    }

    protected function getBlogIds()
    {
        return array_map(function($blog) {
            return $blog->blog_id;
        }, get_sites());
    }
}