<?php

namespace apo\rxts\validation\rules;

use apo\rxts\validation\rules\contracts\Rule;

class Min extends Rule
{
    public function validate( $param, $request, $key, $parameters = [] ) {
        [$min] = $parameters;

        if ( is_float( $param ) ) {
            return (float) $param >= $min;
        }

        if ( is_int( $param ) ) {
            return (int) $param >= $min;
        }

        if ( is_countable( $param ) ) {
            return count( $param ) >= $min;
        }

        return mb_strlen( $param ) >= $min;
    }

    public function message( $param, $key, $parameters = [] ) {
        [$min] = $parameters;

        if ( is_float( $param ) || is_int( $param ) ) {
            $message = __('The value of %s must be greather than %s.', 'rxts');
        } elseif( is_countable( $param ) ) {
            $message = __('The item count of the %s attribute must be at least %s.', 'rxts');
        } else {
            $message = __('The value of %s must be at least %s characters long.', 'rxts');
        }

        return sprintf(
            $message,
            $key,
            $min
        );
    }
}
