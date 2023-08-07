<?php

namespace apo\rxts\validation\rules;

use apo\rxts\validation\rules\contracts\Rule;

class Sometimes extends Rule
{
    public function validate( $param, $request, $key, $parameters = [] ) {
        return true;
    }

    public function message( $param, $key, $parameters = [] ) {
        return '';
    }
}
