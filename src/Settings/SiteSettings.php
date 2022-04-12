<?php

namespace Octo\Settings;

use Spatie\LaravelSettings\Settings;

class SiteSettings extends Settings
{
    public string $name;
    public string $description;
    public bool $active;
    public bool $demo;

    public static function group(): string
    {
        return 'site';
    }
}
