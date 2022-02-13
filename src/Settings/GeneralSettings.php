<?php

namespace Octo\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public array $site;

    public static function group(): string
    {
        return 'general';
    }
}
