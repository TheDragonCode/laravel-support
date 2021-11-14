<?php

namespace DragonCode\LaravelSupport\Support;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Symfony\Component\VarDumper\VarDumper;

class Dumper
{
    /**
     * Throws a message with an SQL query.
     *
     * @see https://gist.github.com/Ellrion/561fc48894a87b853917e0a5cec83181#file-helper-php
     *
     * @param $query
     * @param  bool  $is_short
     */
    public function sqlDd($query, bool $is_short = false): void
    {
        $this->sqlDump($query, $is_short);

        exit(1);
    }

    /**
     * Displays a message with an SQL query.
     *
     * @see https://gist.github.com/Ellrion/561fc48894a87b853917e0a5cec83181#file-helper-php
     *
     * @param $query
     * @param  bool  $is_short
     *
     * @return array|string|void
     */
    public function sqlDump($query, bool $is_short = false): void
    {
        $data = $this->sql($query, $is_short);

        VarDumper::dump($data);
    }

    /**
     * Returns SQL query.
     *
     * @param $query
     * @param  bool  $is_short
     *
     * @return array|string
     */
    public function sql($query, bool $is_short = false)
    {
        $query = $this->prepareQuery($query);

        $sql = $query->toSql();

        $bindings = $this->getBindings($query);

        $raw = $this->getRaw($sql, $bindings);

        return $this->getData($is_short, $sql, $query->getRawBindings(), $raw);
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
