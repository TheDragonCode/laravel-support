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

    public function is9x(): bool
    {
        return $this->major() === 9;
    }

    protected function major(): int
    {
        return (int) Str::before($this->version(), '.');
    }

    protected function version(): string
    {
        if (AppHelper::isLumen()) {
            preg_match('/.+\((\d+\.\d+\.\d+)\)/', app()->version(), $matches);

            return $matches[1];
        }

        return Application::VERSION;
    }
}
