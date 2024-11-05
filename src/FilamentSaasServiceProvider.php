<?php

namespace A2insights\FilamentSaas;

use A2insights\FilamentSaas\Commands\FilamentSaasCommand;
use A2insights\FilamentSaas\Features\FeaturesServiceProvider;
use A2insights\FilamentSaas\Middleware\MiddlewareServiceProvider;
use A2insights\FilamentSaas\Settings\SettingsServiceProvider;
use A2insights\FilamentSaas\Tenant\TenantServiceProvider;
use A2insights\FilamentSaas\User\UserServiceProvider;
use A2insights\FilamentSaas\Webhook\WebhookServiceProvider;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentSaasServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        Route::get('/', fn () => redirect(config('filament-saas.admin_path')));

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
        $this->app->register(MiddlewareServiceProvider::class);
        $this->app->register(TenantServiceProvider::class);
        $this->app->register(WebhookServiceProvider::class);
    }
}
