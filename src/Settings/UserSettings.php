<?php

namespace Octo\Settings;

use Spatie\LaravelSettings\Settings;

class UserSettings extends Settings
{
    public bool $show_notifications;

    public static function group(): string
    {
        return 'user';
    }
}
