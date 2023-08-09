<?php

namespace apo\rxts\validation\rules;

use apo\rxts\validation\rules\contracts\Rule;

class Confirmed extends Rule
{
    public function validate( $param, $request, $key, $parameters = [] ) {
        [$field] = $parameters;

        $field = $this->resolveFieldName( $field, $key );

        return $request->get_param( $field ) === $param;
    }

    public function message( $param, $key, $parameters = [] ) {
        [$field] = $parameters;

        $field = $this->resolveFieldName( $field, $key );

        return sprintf(
            __( 'The value for the %s attribute must match the value of the %s attribute.', 'rxts' ),
            $key,
            $field
        );
    }

    protected function resolveFieldName( $field, $key ) {
        if ( is_null( $field ) ) {
            return "{$key}_confirmation";
        }

        return $field;
    }
}
