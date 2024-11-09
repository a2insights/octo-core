<?php

namespace A2Insights\FilamentSaas\Settings;

use Spatie\LaravelSettings\Settings as BaseSettings;

class TermsSettings extends BaseSettings
{
    public ?string $service;

    public ?string $privacy_policy;

    public static function group(): string
    {
        return 'settings_terms';
    }
}
