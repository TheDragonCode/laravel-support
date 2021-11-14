<?php

namespace DragonCode\LaravelSupport\Facades;

use DragonCode\LaravelSupport\Support\App as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool isLaravel()
 * @method static bool isLumen()
 */
class App extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Support::class;
    }
}
