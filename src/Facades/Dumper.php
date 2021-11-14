<?php

namespace DragonCode\LaravelSupport\Facades;

use DragonCode\LaravelSupport\Support\Dumper as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void sqlDd($query, bool $is_short = false)
 * @method static void sqlDump($query, bool $is_short = false)
 * @method static array|string sql($query, bool $is_short = false)
 */
class Dumper extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Support::class;
    }
}
