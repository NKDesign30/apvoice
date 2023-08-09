<?php

namespace apo\rxts\validation\rules;

use apo\rxts\validation\rules\contracts\Rule;

class Exists extends Rule
{
    public function validate( $param, $request, $key, $parameters = [] ) {
        global $wpdb;

        [$table, $column, $whereClauses] = $parameters;

        return (bool) (int) $wpdb->get_var(
            $this->buildExistsQuery( $param, $table, $column, $whereClauses )
        );
    }

    public function message( $param, $key, $parameters = [] ) {
        return sprintf(
            __( 'The value entered for the %s attribute does not exist.', 'rxts' ),
            $key
        );
    }

    protected function buildExistsQuery( $param, $table, $column, $whereClauses = [] ) {
        global $wpdb;

        $sql = "
            SELECT
                COUNT(`{$column}`)
            FROM
                `{$wpdb->prefix}{$table}`
        ";

        $where = [$wpdb->prepare( "`{$column}` = %s", $param )];

        foreach ($whereClauses as $whereClause) {
            [$whereColumn, $whereOperator, $whereValue] = $whereClause;

            $where[] = $wpdb->prepare( "`{$whereColumn}` {$whereOperator} %s", $whereValue );
        }

        return $sql . ' WHERE ' . implode( ' AND ', $where ) . ';';
    }
}
