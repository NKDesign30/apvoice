<?php

namespace apo\rxts\validation\rules;

use apo\rxts\validation\rules\contracts\Rule;

class In extends Rule
{
    public function validate( $param, $request, $key, $parameters = [] ) {
        [$values] = $parameters;

        return in_array( $param, $values );
    }

    public function message( $param, $key, $parameters = [] ) {
        [$values] = $parameters;

        return sprintf(
            __( 'The value for %s must be one of %s.', 'rxts' ),
            $key,
            implode( ', ', $values )
        );
    }
}
