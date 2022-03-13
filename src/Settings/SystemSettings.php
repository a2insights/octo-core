<?php

namespace Octo\Settings;

use Spatie\LaravelSettings\Settings;

class SystemSettings extends Settings
{
    public bool $show_notifications;

    public static function group(): string
    {
        return 'system';
    }
}
