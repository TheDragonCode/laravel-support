<?php

declare(strict_types=1);

namespace DragonCode\LaravelSupport\Support;

use DragonCode\LaravelSupport\Facades\App as AppHelper;
use Illuminate\Foundation\Application;
use Illuminate\Support\Str;

class AppVersion
{
    public function is6x(): bool
    {
        return $this->major() === 6;
    }

    public function is7x(): bool
    {
        return $this->major() === 7;
    }

    public function is8x(): bool
    {
        return $this->major() === 8;
    }

    protected function major(): int
    {
        return (int) Str::before($this->version(), '.');
    }

    protected function version(): string
    {
        if (AppHelper::isLumen()) {
            $version = app()->version();

            $version = Str::after($version, '(');
            $version = Str::before($version, ')');

            return $version;
        }

        return Application::VERSION;
    }
}
