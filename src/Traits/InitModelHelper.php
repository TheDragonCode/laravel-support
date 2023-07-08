<?php

namespace DragonCode\LaravelSupport\Traits;

use DragonCode\LaravelSupport\Support\ModelHelper;
use Illuminate\Container\Container;

trait InitModelHelper
{
    /** @var \DragonCode\LaravelSupport\Support\ModelHelper */
    protected static $model_helper;

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function model(): ModelHelper
    {
        if (static::$model_helper) {
            return static::$model_helper;
        }

        return static::$model_helper = Container::getInstance()->make(ModelHelper::class);
    }
}
