<?php

namespace Octo\Features;

use Spatie\LaravelSettings\Settings as BaseSettings;

class Features extends BaseSettings
{
    // TODO: dark_mode
    public bool $dark_mode;

    // TODO: auth_login
    public bool $auth_login;

    // TODO: auth_2fa
    public bool $auth_2fa;

    // TODO: auth_registration
    public bool $auth_registration;

    public bool $webhooks;

    //TODO: reCAPTCHA
    public bool $recaptcha;

    public bool $terms;

    public bool $user_phone;

    public bool $username;

    public bool $switch_language;

    public static function group(): string
    {
        return 'features';
    }
}
