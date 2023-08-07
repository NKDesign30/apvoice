<?php

namespace awsm\wp\libraries\rest;

trait RegisterRestFieldTrait
{

    /**
     *  Registers a new field on given WordPress object type.
     * @param $attribute string
     * @param $args array
     */
    function registerRestField($attribute, $args)
    {
        register_rest_field( $this->objectType, $attribute, $args);
    }

}