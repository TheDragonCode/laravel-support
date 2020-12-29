<?php

namespace Helldar\LaravelSupport\Facades;

use Helldar\LaravelSupport\Support\Dumper as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void|string|array ddSql($query, bool $is_short = false, bool $is_return = false)
 */
class Dumper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
