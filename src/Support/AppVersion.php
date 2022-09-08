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

    public function is10x(): bool
    {
        return $this->major() === 10;
    }

    public function major(): int
    {
        return (int) Str::before($this->version(), '.');
    }

    public function minor(): int
    {
        $version = $this->parse();

        return $version[1];
    }

    public function patch(): int
    {
        $version = $this->parse();

        return $version[2];
    }

    public function is(string $version, string $comparator = '>='): bool
    {
        return version_compare($this->version(), $version, $comparator);
    }

    public function version(): string
    {
        if (AppHelper::isLumen()) {
            preg_match('/.+\((\d+\.\d+|\d+\.\d+\.\d+)\).+/', app()->version(), $matches);

            return $matches[1];
        }

        return Application::VERSION;
    }

    protected function parse(): array
    {
        return explode('.', $this->version());
    }
}
