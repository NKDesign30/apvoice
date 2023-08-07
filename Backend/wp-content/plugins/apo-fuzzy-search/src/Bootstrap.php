<?php

namespace apo\fuzzysearch;

use awsm\wp\libraries\DB;
use awsm\wp\libraries\utilities\DatabaseUtils;
use awsm\wp\libraries\utilities\Migratable;
use awsm\wp\libraries\interfaces\CreateSchemasInterface;

class Bootstrap implements CreateSchemasInterface {

    use DatabaseUtils, Migratable;

    protected $db;

    protected $networkWide;

    protected $schemas;
    
    public function __construct($networkWide = true) 
    {
        $this->db = DB::instance();
        $this->schemas = [];
        $this->networkWide = $networkWide;
        return $this;
    }

    public function createSchemas()
    {
        return $this;
    }

    public function down()
    {
        return $this;
    }

}
