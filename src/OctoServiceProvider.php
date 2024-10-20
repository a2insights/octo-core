<?php

namespace Octo;

use Illuminate\Support\Facades\Route;
use Octo\Features\FeaturesServiceProvider;
use Octo\Middleware\MiddlewareServiceProvider;
use Octo\Settings\SettingsServiceProvider;
use Octo\Tenant\TenantServiceProvider;
use Octo\User\UserServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class OctoServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $this->app->register(UserServiceProvider::class);
        $this->app->register(FeaturesServiceProvider::class);
        $this->app->register(SettingsServiceProvider::class);
        $this->app->register(MiddlewareServiceProvider::class);
        $this->app->register(TenantServiceProvider::class);

        Route::get('/', fn() => redirect(config('octo.admin_path')));

        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('octo-core')
            ->hasViews('octo')
            ->hasConfigFile('octo')
            ->hasTranslations()
            ->hasCommand(Console\OctoInstallCommand::class);
    }
}
