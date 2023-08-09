<?php

namespace apo\rxts\validation;

use apo\rxts\validation\rules\{
    Nullable,
    Sometimes,
};

class Validator
{
    public static function rules( $rule_definitions ) {
        return array_map_keys( $rule_definitions, function ( $rules, $key ) {
            return [
                'validate_callback' => function ( $param, $request ) use ( $rules, $key ) {
                    if ( ! static::shouldValidateAgainstAllRules( $request, $param, $key, $rules ) ) {
                        return true;
                    }

                    $return_values = static::validate( $rules, $param, $request, $key );

                    $error_messages = array_values( array_filter( $return_values, function ( $return_value ) {
                        return $return_value !== true;
                    } ) );

                    if ( count( $error_messages ) === 0 ) {
                        return true;
                    }

                    return new \WP_Error( $key, $error_messages );
                },
            ];
        } );
    }

    protected static function validate( array $rules, $param, $request, $key ) {
        return array_map_keys( $rules, function ( $rule ) use ( $param, $request, $key ) {
            $passes = call_user_func_array( [$rule, 'validate'], [$param, $request, $key, $rule->parameters] );

            if ( $passes ) {
                return true;
            } else {
                return call_user_func_array( [$rule, 'message'], [$param, $key, $rule->parameters] );
            }
        } );
    }

    protected static function shouldValidateAgainstAllRules( $request, $param, $key, array $rules ) {
        if ( static::containsSometimesRule( $rules ) ) {
            if ( ! array_key_exists( $key, $request->get_params() ) ) {
                return false;
            }

            if ( static::containsNullableRule( $rules ) ) {
                return ! empty( $param ) && ! is_null( $param );
            }
        }

        return true;
    }

    protected static function containsSometimesRule( array $rules ) {
        return array_some( $rules, function ( $rule ) {
            return $rule instanceof Sometimes;
        } );
    }

    protected static function containsNullableRule( array $rules ) {
        return array_some( $rules, function ( $rule ) {
            return $rule instanceof Nullable;
        } );
    }
}
