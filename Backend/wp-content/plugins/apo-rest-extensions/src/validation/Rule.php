<?php

namespace apo\rxts\validation;

use apo\rxts\validation\rules\{
    Confirmed,
    DateFormat,
    Email,
    Exists,
    Image,
    In,
    IsArray,
    Min,
    Nullable,
    Numeric,
    Required,
    RequiredIf,
    Sometimes,
    Unique,
    When,
};

class Rule
{
    public static function confirmed( $field = null ) {
        return new Confirmed( $field );
    }

    public static function dateFormat( $format ) {
        return new DateFormat( $format );
    }

    public static function email() {
        return new Email();
    }

    public static function exists( $table, $column = 'id', ...$whereClauses ) {
        return new Exists( $table, $column, $whereClauses );
    }

    public static function image() {
        return new Image();
    }

    public static function in( array $haystack ) {
        return new In( $haystack );
    }

    public static function isArray() {
        return new IsArray();
    }

    public static function min( $amount ) {
        return new Min( $amount );
    }

    public static function nullable() {
        return new Nullable();
    }

    public static function numeric() {
        return new Numeric();
    }

    public static function required() {
        return new Required();
    }

    public static function requiredIf( $callback ) {
        return new RequiredIf( $callback );
    }

    public static function sometimes() {
        return new Sometimes();
    }

    public static function unique( $table, $column, $except = null, $except_column = 'ID' ) {
        return new Unique( $table, $column, $except, $except_column );
    }

    public static function when( $condition_callback, $validation_callback, $message_callback ) {
        return new When( $condition_callback, $validation_callback, $message_callback );
    }
}
