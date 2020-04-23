<?php

namespace Helldar\LaravelSupport\Eloquent\Relations;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Arr;

class HasManyCustomRelation extends Relation
{
    protected $local_key;

    protected $foreign_key;

    public function __construct(Builder $query, Model $parent, string $foreign_key, string $local_key)
    {
        $this->foreign_key = $foreign_key;
        $this->local_key   = $local_key;

        parent::__construct($query, $parent);
    }

    public function addConstraints()
    {
        if (! static::$constraints || ! $this->getParentKey()) {
            return;
        }

        $is_array_local   = $this->parent->hasCast($this->local_key, 'array');
        $is_array_foreign = $this->related->hasCast($this->getForeignKeyName(), 'array');

        $where_in = $this->getWhereInMethod();

        if ($is_array_local && ! $is_array_foreign) {
            $this->query->{$where_in}(
                $this->getForeignKeyName(),
                $this->getParentKey()
            );

            return;
        }

        if (! $is_array_local && $is_array_foreign) {
            $this->query->{$where_in}(
                $this->local_key,
                $this->getForeignKeyName()
            );

            return;
        }

        $this->query->where($this->getForeignKeyName(), $this->local_key);
    }

    public function addEagerConstraints(array $models)
    {
        $where_in = $this->getWhereInMethod();

        $values = Arr::collapse(
            $this->getKeys($models, $this->local_key)
        );

        $this->query->{$where_in}(
            $this->foreign_key, $values
        );
    }

    public function initRelation(array $models, $relation)
    {
        foreach ($models as $model) {
            $model->setRelation($relation, $this->related->newCollection());
        }

        return $models;
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model[]  $models
     * @param  \Illuminate\Database\Eloquent\Collection  $results
     * @param  string  $relation
     *
     * @return array
     */
    public function match(array $models, Collection $results, $relation)
    {
        foreach ($models as $model) {
            $filtered = $results->filter(function ($result) use ($model) {
                $local   = $model->getAttribute($this->local_key);
                $foreign = $result->getAttribute($this->getForeignKeyName());

                if (is_array($local) && ! is_array($foreign)) {
                    return in_array($foreign, $local, true);
                }

                if (! is_array($local) && is_array($foreign)) {
                    return in_array($local, $foreign, true);
                }

                return $local === $foreign;
            })->values();

            if ($filtered) {
                $model->setRelation($relation, $filtered);
            }
        }

        return $models;
    }

    public function getResults()
    {
        return ! is_null($this->getParentKey())
            ? $this->query->get()
            : $this->related->newCollection();
    }

    protected function getWhereInMethod()
    {
        return $this->whereInMethod($this->parent, $this->local_key);
    }

    protected function getParentKey()
    {
        return $this->parent->getAttribute($this->local_key);
    }

    protected function getForeignKeyName()
    {
        $segments = explode('.', $this->getQualifiedForeignKeyName());

        return end($segments);
    }

    /**
     * Get the foreign key for the relationship.
     *
     * @return string
     */
    protected function getQualifiedForeignKeyName()
    {
        return $this->foreign_key;
    }
}
