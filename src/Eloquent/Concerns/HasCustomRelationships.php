<?php

namespace DragonCode\LaravelSupport\Eloquent\Concerns;

use DragonCode\LaravelSupport\Eloquent\Relations\HasManyCustomRelation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/** @mixin \Illuminate\Database\Eloquent\Model */
trait HasCustomRelationships
{
    protected function hasManyCustom(string $related, ?string $foreign_key = null, ?string $local_key = null)
    {
        /** @var Model $instance */
        $instance = $this->newRelatedInstance($related);

        $local_key     = $local_key ?: $this->getKeyName();
        $foreign_key   = $foreign_key ?: $this->getForeignKey();
        $foreign_table = $instance->getTable();

        /** @var Model $model */
        $model = $this;

        return $this->newHasManyCustom(
            $instance->newQuery(),
            $model,
            "$foreign_table.$foreign_key",
            $local_key
        );
    }

    protected function newHasManyCustom(Builder $builder, Model $model, string $foreign_key, string $local_key): HasManyCustomRelation
    {
        return new HasManyCustomRelation($builder, $model, $foreign_key, $local_key);
    }
}
