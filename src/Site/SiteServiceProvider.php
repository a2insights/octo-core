<?php

namespace A2Insights\FilamentSaas\Site;

use A2Insights\FilamentSaas\Settings\Settings;
use A2Insights\FilamentSaas\Site\Http\Controllers\SiteController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SiteServiceProvider extends PackageServiceProvider
{
    protected Settings $settings;

    public function configurePackage(Package $package): void
    {
        $package->name('filament-saas.site');

        Route::get('/', [SiteController::class, 'home'])
            ->middleware('web')
            ->name('filament-saas::site.home');
        Route::get('/terms-of-service', [SiteController::class, 'termsOfService'])
            ->middleware('web')
            ->name('filament-saas::site.terms-of-service');
        Route::get('/privacy-policy', [SiteController::class, 'privacyPolicy'])
            ->middleware('web')
            ->name('filament-saas::site.privacy-policy');
    }

    public function packageBooted(): void
    {
        parent::packageBooted();

        // return if running in the console
        if (App::runningInConsole()) {
            return;
        }
    }
}
