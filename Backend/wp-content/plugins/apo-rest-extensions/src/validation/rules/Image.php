<?php

namespace apo\rxts\validation\rules;

use apo\rxts\validation\rules\contracts\Rule;

class Image extends Rule
{
    public function validate( $param, $request, $key, $parameters = [] ) {
        return false;
    }

    public function message( $param, $key, $parameters = [] ) {
        return sprintf(
            __( 'The %s file must be an image.', 'rxts' ),
            $key
        );
    }
}
