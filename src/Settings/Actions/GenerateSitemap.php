<?php

namespace A2Insights\FilamentSaas\Settings\Actions;

use A2Insights\FilamentSaas\Settings\Settings;
use A2Insights\FilamentSaas\Settings\SitemapSettings;
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap
{
    use AsAction;

    /**
     * Generates the sitemap based on the application settings.
     *
     * @return void
     */
    public function handle(): void
    {
        $sitemapSettings = app(SitemapSettings::class);
        $settings = app(Settings::class);

        $storageFilePath = storage_path('app/public/sitemap.xml');
        $publicFilePath = public_path('sitemap.xml');

        if (!$settings->sitemap) {
            unlink($storageFilePath);
            unlink($publicFilePath);

            return;
        }

        $storageFilePath = storage_path('app/public/sitemap.xml');
        $publicFilePath = public_path('sitemap.xml');
        $pages = $sitemapSettings->pages;

        $sitemap = Sitemap::create();

        foreach ($pages as $page) {
            $sitemap->add(Url::create($page['path']));
        }

        $sitemap->writeToFile($storageFilePath);

        file_put_contents($publicFilePath, file_get_contents($storageFilePath));
    }
}
