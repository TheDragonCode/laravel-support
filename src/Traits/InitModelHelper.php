<?php

namespace Helldar\LaravelSupport\Traits;

use Helldar\LaravelSupport\Support\ModelHelper;
use Illuminate\Container\Container;

trait InitModelHelper
{
    /** @var \Helldar\LaravelSupport\Support\ModelHelper */
    protected static $model_helper;

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return \Helldar\LaravelSupport\Support\ModelHelper
     */
    protected function model(): ModelHelper
    {
        if (static::$model_helper === null) {
            static::$model_helper = Container::getInstance()
                ->make(ModelHelper::class);
        }

        return static::$model_helper;
    }
}
