<?php

namespace Octo\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name;

    public bool $site_active;

    public string $site_description;

    public array $site_sections;

    public static function group(): string
    {
        return 'general';
    }
}
