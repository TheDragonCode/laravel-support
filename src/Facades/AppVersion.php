<?php

declare(strict_types=1);

namespace DragonCode\LaravelSupport\Facades;

use DragonCode\LaravelSupport\Support\AppVersion as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool is6x()
 * @method static bool is7x()
 * @method static bool is8x()
 */
class AppVersion extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Support::class;
    }
}
