<?php

namespace apo\rxts\validation\rules\contracts;

abstract class Rule
{
    public $parameters = [];

    public function __construct( ...$parameters ) {
        $this->parameters = $parameters;
    }

    public function validate( $param, $request, $key, $parameters = [] ) {
        return false;
    }

    public function message( $param, $key, $parameters = [] ) {
        return "Invalid value for {$key}.";
    }
}
