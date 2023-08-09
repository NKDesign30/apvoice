<?php

namespace apo\rxts\validation\rules;

use apo\rxts\validation\rules\contracts\Rule;

class RequiredIf extends Rule
{
    public function validate( $param, $request, $key, $parameters = [] ) {
        [$condition_callback] = $parameters;

        if ( $condition_callback( $param, $request, $key ) ) {
            return ( new Required() )->validate( $param, $request, $key );
        }

        return true;
    }

    public function message( $param, $key, $parameters = [] ) {
        return ( new Required() )->message( $param, $key );
    }
}
