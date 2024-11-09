<?php

namespace A2Insights\FilamentSaas;

class FilamentSaas
{
    public static function getUserModel(): string
    {
        return config('filament-saas.user.model', 'App\\Models\\User');
    }

    public static function getCompanyModel(): string
    {
        return config('filament-saas.companies.model', 'App\\Models\\Company');
    }
}
