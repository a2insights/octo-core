<?php

namespace Octo\Settings;

use Spatie\LaravelSettings\Settings as BaseSettings;

class Settings extends BaseSettings
{
    public string $name;

    public string $description;

    public array $keywords;

    public bool $dark;

    public string $theme;

    public string $logo;

    public string $favicon;

    public bool $auth_registration;

    public bool $auth_login;

    public array $restrict_ips;

    public array $restrict_users;

    public static function group(): string
    {
        return 'settings';
    }
}
