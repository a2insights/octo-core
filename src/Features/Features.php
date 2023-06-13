<?php

namespace Octo\Features;

use Spatie\LaravelSettings\Settings as BaseSettings;

class Features extends BaseSettings
{
    public bool $dark_mode;

    public bool $auth_login;

    public bool $auth_2fa;

    public bool $auth_registration;

    public bool $webhooks;

    public bool $recaptcha;

    public static function group(): string
    {
        return 'features';
    }
}
