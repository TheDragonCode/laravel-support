<?php

namespace Helldar\LaravelSupport\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

abstract class UuidModel extends Model
{
    public $incrementing = false;

    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            /** @var \Illuminate\Database\Eloquent\Model $model */
            if (! ($model->attributes[$model->primaryKey] ?? false)) {
                $model->attributes[$model->primaryKey] = (string) Uuid::uuid4();
            }
        });
    }

    public function getRouteKeyName()
    {
        return $this->primaryKey;
    }
}
