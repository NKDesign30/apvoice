<?php

namespace apo\rxts\validation\rules;

use apo\rxts\validation\rules\contracts\Rule;

class Required extends Rule
{
    public function validate( $param, $request, $key, $parameters = [] ) {
        return array_key_exists( $key, $request->get_params() )
            && mb_strlen( (string) $param ) > 0;
    }

    public function message( $param, $key, $parameters = [] ) {
        return sprintf(
            __( 'The %s attribute is required.', 'rxts' ),
            $key
        );
    }
}
