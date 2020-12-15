<?php

namespace Helldar\LaravelSupport\Facades;

use Helldar\LaravelSupport\Support\App as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool isLaravel()
 * @method static bool isLumen()
 */
final class App extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
