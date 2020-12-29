<?php

namespace Helldar\LaravelSupport\Support;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Dumper
{
    /**
     * Dump the passed variables and end the script.
     *
     * @see https://gist.github.com/Ellrion/561fc48894a87b853917e0a5cec83181#file-helper-php
     *
     * @param $query
     * @param  bool  $is_short
     * @param  bool  $is_return
     *
     * @return array|string
     */
    public function ddSql($query, bool $is_short = false, bool $is_return = false)
    {
        $query = $this->prepareQuery($query);

        $sql = $query->toSql();

        $bindings = $this->getBindings($query);

        $raw = $this->getRaw($sql, $bindings);

        $data = $this->getData($is_short, $sql, $query->getRawBindings(), $raw);

        if ($is_return) {
            return $data;
        }

        dd($data);
    }

    protected function prepareQuery($query): QueryBuilder
    {
        return $query instanceof Builder ? $query->getQuery() : $query;
    }

    protected function getBindings(QueryBuilder $builder): array
    {
        return array_map(function ($binding) {
            return is_numeric($binding) ? $binding : "'{$binding}'";
        }, $builder->getBindings());
    }

    protected function getData(bool $is_short, string $sql, array $bindings, string $raw)
    {
        return $is_short ? $raw : compact('sql', 'bindings', 'raw');
    }

    protected function getRaw(string $sql, array $bindings): string
    {
        return vsprintf(str_replace(['%', '?'], ['%%', '%s'], $sql), $bindings);
    }
}
