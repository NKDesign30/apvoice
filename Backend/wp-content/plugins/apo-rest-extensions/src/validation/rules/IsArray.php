<?php

namespace apo\rxts\validation\rules;

use apo\rxts\validation\rules\contracts\Rule;

class IsArray extends Rule
{
    public function validate( $param, $request, $key, $parameters = [] ) {
        return is_array( $param );
    }

    public function message( $param, $key, $parameters = [] ) {
        return sprintf(
            __( 'The %s attribute must be an array of values.', 'rxts' ),
            $key
        );
    }
}
