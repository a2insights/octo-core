<?php

namespace A2Insights\FilamentSaas\Settings;

use A2Insights\FilamentSaas\Settings\Filament\Pages\Policy;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelSettings\Events\SettingsSaved;

class SettingsServiceProvider extends PackageServiceProvider
{
    protected Settings $settings;

    public function configurePackage(Package $package): void
    {
        $package->name('filament-saas.settings');

        Route::get('/terms-of-service', fn () => Inertia::render('TermsOfService', [
            'dashboardUrl' => 'ass',
        ]))
            ->middleware('web')
            ->name('filament-saas::terms-of-service');

        Route::get('/privacy-policy', Policy::class)
            ->middleware('web')
            ->name('filament-saas::privacy-policy');
    }

    public function packageBooted(): void
    {
        parent::packageBooted();

        // TODO: In logger not will be set. Implement it
        // return if running in the console
        if (App::runningInConsole()) {
            return;
        }

        Event::listen(function (SettingsSaved $event) {
            Cache::forget('filament-saas.settings');
        });

        $this->settings = Cache::remember('filament-saas.settings', now()->addHours(10), fn () => app(Settings::class));

        $this->syncName();
        $this->syncTimezone();
        // $this->syncLocale(); // See locale middleware
    }

    private function syncTimezone(): void
    {
        $timezone = $this->settings->timezone;

        if ($timezone) {
            Config::set('app.timezone', $timezone);
            date_default_timezone_set($timezone);
        }
    }

    /*************  ✨ Codeium Command ⭐  *************/
    /**
     * Synchronize the site name with the application.
     *
     * The `app.name` config is updated with the value of the `name` setting.
     */
    /******  37ede71f-c48d-4f54-ad50-cd3749519905  *******/
    private function syncName(): void
    {
        $name = $this->settings->name;
        // $description = $this->settings->description;
        // $keywords = $this->settings->keywords;

        if ($name) {
            Config::set('app.name', $name);
        }
    }

    // private function syncLocale(): void
    // {
    //     $locale = $this->settings->locale;

    //     if ($locale) {
    //         Config::set('app.locale', $locale);
    //         App::setLocale($locale);
    //         \Locale::setDefault($locale);
    //     }
    // }
}
