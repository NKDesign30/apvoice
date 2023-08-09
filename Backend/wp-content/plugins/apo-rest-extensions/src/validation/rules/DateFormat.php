<?php

namespace apo\rxts\validation\rules;

use apo\rxts\validation\rules\contracts\Rule;

class DateFormat extends Rule
{
    public function validate( $param, $request, $key, $parameters = [] ) {
        [$format] = $parameters;

        $date = \DateTime::createFromFormat('!' . $format, $param);

        return $date && $date->format($format) === $param;
    }

    public function message( $param, $key, $parameters = [] ) {
        [$format] = $parameters;

        return sprintf(
            __( 'The %s attribute must be in the format %s.', 'rxts' ),
            $key,
            $format
        );
    }
}
