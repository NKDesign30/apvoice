<?php

namespace apo\rxts\validation\rules;

use apo\rxts\validation\rules\contracts\Rule;

class Email extends Rule
{
    public function validate( $param, $request, $key, $parameters = [] ) {
        return trim($param) === "" || filter_var( $param, FILTER_VALIDATE_EMAIL ) !== false;
    }

    public function message( $param, $key, $parameters = [] ) {
        return sprintf(
            __( 'The %s attribute must be a valid email address.', 'rxts' ),
            $key
        );
    }
}
