<?php

namespace A2insights\FilamentSaas\Settings;

use Spatie\LaravelSettings\Settings as BaseSettings;

class reCAPTCHASettings extends BaseSettings
{
    public ?string $project_id;

    public ?string $site_key;

    public ?string $secret_key;

    public static function group(): string
    {
        return 'recaptcha_settings';
    }
}
