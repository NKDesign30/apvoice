<?php

namespace apo\rxts\validation\rules;

use apo\rxts\validation\rules\contracts\Rule;

class When extends Rule
{
    public function validate( $param, $request, $key, $parameters = [] ) {
        [$condition_callback, $validation_callback, $message_callback] = $parameters;

        if ( $condition_callback( $param, $request, $key ) ) {
            return $validation_callback( $param, $request, $key );
        }

        return true;
    }

    public function message( $param, $key, $parameters = [] ) {
        [$condition_callback, $validation_callback, $message_callback] = $parameters;

        return $message_callback( $param, $key );
    }
}
