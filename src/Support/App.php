<?php

namespace Helldar\LaravelSupport\Support;

use Illuminate\Foundation\Application as LaravelApp;
use Laravel\Lumen\Application as LumenApp;

final class App
{
    public function isLaravel(): bool
    {
        return class_exists(LaravelApp::class);
    }

    public function isLumen(): bool
    {
        return class_exists(LumenApp::class);
    }
}
