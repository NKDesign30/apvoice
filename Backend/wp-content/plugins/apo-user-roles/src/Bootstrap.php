<?php

namespace apo\userroles;

use apo\userroles\roles\Roles;
use awsm\wp\libraries\DB;
use awsm\wp\libraries\utilities\DatabaseUtils;
use awsm\wp\libraries\utilities\Migratable;
use awsm\wp\libraries\interfaces\CreateSchemasInterface;

class Bootstrap implements CreateSchemasInterface {

    use DatabaseUtils, Migratable;
    
    public $roles;

    protected $db;

    protected $networkWide;

    protected $schemas;
    
    public function __construct($networkWide = true) 
    {
        $this->db = DB::instance();
        $this->schemas = [];
        $this->networkWide = $networkWide;

        $this->roles = new Roles($networkWide);
        return $this;
    }

    public function createSchemas()
    {
        return $this;
    }

    public function createRoles()
    {
        $this->roles->create();

        return $this;
    }

    public function down()
    {
        $this->roles->remove();

        return $this;
    }

}
