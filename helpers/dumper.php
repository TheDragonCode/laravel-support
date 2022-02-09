<?php

use DragonCode\LaravelSupport\Facades\Dumper;

if (! function_exists('dd_sql')) {
    /**
     * Throws a message with an SQL query.
     *
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query
     * @param bool $is_short
     */
    function dd_sql($query, bool $is_short = false): void
    {
        Dumper::sqlDd($query, $is_short);
    }
}

if (! function_exists('dump_sql')) {
    /**
     * Displays a message with an SQL query.
     *
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query
     * @param bool $is_short
     */
    function dump_sql($query, bool $is_short = false): void
    {
        Dumper::sqlDump($query, $is_short);
    }
}

if (! function_exists('sql')) {
    /**
     * Displays a message with an SQL query.
     *
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query
     * @param bool $is_short
     *
     * @return array|string
     */
    function sql($query, bool $is_short = false)
    {
        return Dumper::sql($query, $is_short);
    }
}
