<?php

namespace apo\rxts\validation\rules;

use apo\rxts\validation\rules\contracts\Rule;

class Unique extends Rule
{
    public function validate( $param, $request, $key, $parameters = [] ) {
        global $wpdb;

        [$table, $column, $except, $except_column] = $parameters;

        return ! (bool) (int) $wpdb->get_var(
            $this->buildExistsQuery( $param, $table, $column, $except, $except_column )
        );
    }

    public function message( $param, $key, $parameters = [] ) {
        return sprintf(
            __( 'The value entered for the %s attribute is not unique.', 'rxts' ),
            $key
        );
    }

    protected function buildExistsQuery( $param, $table, $column, $except, $except_column ) {
        global $wpdb;

        $sql = "
            SELECT
                COUNT(`{$column}`)
            FROM
                `{$wpdb->prefix}{$table}`
        ";

        $where = [$wpdb->prepare( "`{$column}` = %s", $param )];

        if ( ! is_null( $except ) ) {
            $where[] = $wpdb->prepare( "`{$except_column}` != %s", $except );
        }

        return $sql . ' WHERE ' . implode( ' AND ', $where ) . ';';
    }
}
