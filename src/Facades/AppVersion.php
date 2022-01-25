<?php

declare(strict_types=1);

namespace DragonCode\LaravelSupport\Facades;

use DragonCode\LaravelSupport\Support\AppVersion as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool is6x()
 * @method static bool is7x()
 * @method static bool is8x()
 * @method static bool is9x()
 * @method static int major()
 * @method static int minor()
 * @method static int patch()
 * @method static string version()
 */
class AppVersion extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Support::class;
    }
}
