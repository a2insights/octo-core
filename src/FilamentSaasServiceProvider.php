<?php

namespace A2Insights\FilamentSaas;

use A2Insights\FilamentSaas\Commands\FilamentSaasCommand;
use A2Insights\FilamentSaas\Features\FeaturesServiceProvider;
use A2Insights\FilamentSaas\Middleware\MiddlewareServiceProvider;
use A2Insights\FilamentSaas\Settings\SettingsServiceProvider;
use A2Insights\FilamentSaas\System\SystemServiceProvider;
use A2Insights\FilamentSaas\Tenant\TenantServiceProvider;
use A2Insights\FilamentSaas\User\UserServiceProvider;
use A2Insights\FilamentSaas\Webhook\WebhookServiceProvider;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentSaasServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('filament-saas')
            ->hasViews('filament-saas')
            ->hasConfigFile('filament-saas')
            ->hasTranslations()
            ->hasCommand(FilamentSaasCommand::class);
    }

    public function bootingPackage()
    {
        $this->app->register(UserServiceProvider::class);
        $this->app->register(FeaturesServiceProvider::class);
        $this->app->register(SettingsServiceProvider::class);
        $this->app->register(SystemServiceProvider::class);
        $this->app->register(MiddlewareServiceProvider::class);
        $this->app->register(TenantServiceProvider::class);
        $this->app->register(WebhookServiceProvider::class);
    }

    public function boot()
    {
        parent::boot();

        FilamentAsset::register([
            Css::make('filament-banner', base_path('vendor/kenepa/banner/resources/dist/banner.css')),
        ]);
    }
}
