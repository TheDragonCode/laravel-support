<?php

namespace DragonCode\LaravelSupport\Eloquent;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;

abstract class CompositeKeysModel extends Model
{
    public $incrementing = false;

    /**
     * ATTENTION!
     *
     * Be sure to fill in the columns.
     *
     * @var array
     */
    protected $primaryKey = [];

    public function getAttribute($key)
    {
        if (! is_array($key)) {
            return parent::getAttribute($key);
        }

        return null;
    }

    public function find($id, $columns = ['*'])
    {
        if (is_array($id)) {
            $keys = array_filter($id, function ($key) {
                return $this->hasPrimary($key);
            }, ARRAY_FILTER_USE_KEY);

            if (! empty($keys)) {
                return $this->where($id)->first($columns);
            }
        }

        return is_array($id) || $id instanceof Arrayable
            ? $this->findMany($id, $columns)
            : $this->whereKey($id)->first($columns);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery($query)
    {
        /** @var array|string $keys */
        $keys = $this->primaryKey;

        if (! is_array($keys)) {
            return $query->where($keys, $this->getAttribute($keys));
        }

        foreach ($keys as $key) {
            $query->where($key, $this->getAttribute($key));
        }

        return $query;
    }

    protected function hasPrimary(string $key): bool
    {
        return in_array($key, $this->primaryKey);
    }
}
