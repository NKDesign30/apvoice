<?php

namespace awsm\wp\libraries\rest;
use awsm\wp\libraries\interfaces\RegisterableInterface;
use awsm\wp\libraries\rest\RegisterRestFieldTrait;

class RegisterRestField implements RegisterableInterface
{

    use RegisterRestFieldTrait;

    protected $objectType;

    public function __construct($objectType)
    {
        $this->objectType = $objectType;
    }

    /**
	 * Registers the fields for the given object type.
	 */
    public function register()
    {
        _doing_it_wrong( 'RegisterRestField::register', 'Method must be overridden - ' . __METHOD__ , '5.0' );
    }

}