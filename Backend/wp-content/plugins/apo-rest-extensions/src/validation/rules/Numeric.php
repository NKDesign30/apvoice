<?php

namespace apo\rxts\validation\rules;

use apo\rxts\validation\rules\contracts\Rule;

class Numeric extends Rule
{
    public function validate( $param, $request, $key, $parameters = [] ) {
        return is_numeric( $param );
    }

    public function message( $param, $key, $parameters = [] ) {
        return sprintf( __( 'The value for the %s attribute must be numeric.', 'rxts' ), $key );
    }
}
