<?php

namespace A2Insights\FilamentSaas\Settings;

use Spatie\LaravelSettings\Settings as BaseSettings;

class SitemapSettings extends BaseSettings
{
    public array $pages = [];

    public static function group(): string
    {
        return 'sitemap_settings';
    }
}
