<?php

namespace DragonCode\LaravelSupport\Support;

use DragonCode\LaravelSupport\Exceptions\IncorrectModelException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ModelHelper
{
    private $models = [];

    /**
     * @param  \Illuminate\Database\Eloquent\Model|string  $model
     *
     * @throws \DragonCode\LaravelSupport\Exceptions\IncorrectModelException
     *
     * @return string
     */
    public function connection($model): ?string
    {
        return $this
            ->model($model)
            ->getConnectionName();
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model|string  $model
     *
     * @throws \DragonCode\LaravelSupport\Exceptions\IncorrectModelException
     */
    public function table($model): string
    {
        return $this
            ->model($model)
            ->getTable();
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model|string  $model
     *
     * @throws \DragonCode\LaravelSupport\Exceptions\IncorrectModelException
     */
    public function tableWithConnection($model): string
    {
        $connection = $this->connection($model);
        $table      = $this->table($model);

        return $connection
            ? $connection . '.' . $table
            : $table;
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model|string  $model
     *
     * @throws \DragonCode\LaravelSupport\Exceptions\IncorrectModelException
     */
    public function primaryKey($model): string
    {
        return $this
            ->model($model)
            ->getKeyName();
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model|string  $model
     *
     * @throws \DragonCode\LaravelSupport\Exceptions\IncorrectModelException
     */
    public function primaryKeyType($model): string
    {
        return $this
            ->model($model)
            ->getKeyType();
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model|string  $model
     *
     * @throws \DragonCode\LaravelSupport\Exceptions\IncorrectModelException
     */
    public function query($model): Builder
    {
        return $this
            ->model($model)
            ->newQuery();
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model|string  $model
     */
    public function className($model): string
    {
        return is_string($model) ? $model : get_class($model);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model|string  $model
     *
     * @throws \DragonCode\LaravelSupport\Exceptions\IncorrectModelException
     */
    public function fillable($model): array
    {
        return $this
            ->model($model)
            ->getFillable();
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model|string  $model
     * @param  \Illuminate\Http\Request  $request
     *
     * @throws \DragonCode\LaravelSupport\Exceptions\IncorrectModelException
     */
    public function onlyFillable($model, $request): array
    {
        return $request->only(
            $this->fillable($model)
        );
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model|string  $model
     * @param  array<string>  ...$except
     *
     * @throws IncorrectModelException
     */
    public function exceptFillable($model, ...$except): array
    {
        return array_diff($this->fillable($model), (array) $except);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model|string  $model
     *
     * @throws IncorrectModelException
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function model($model)
    {
        if ($model instanceof Model) {
            $name = get_class($model);

            return $this->models[$name] = $model;
        }

        if (is_string($model)) {
            return $this->models[$model] = new $model();
        }

        throw new IncorrectModelException($model);
    }
}
