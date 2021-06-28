<?php

namespace Helldar\LaravelSupport\Eloquent;

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
        return ! is_array($key)
            ? parent::getAttribute($key)
            : null;
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
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
}
