<?php

namespace A2Insights\FilamentSaas\Features;

use A2Insights\FilamentSaas\Features\Filament\Components\SwitchLanguage;
use A2Insights\FilamentSaas\Features\Filament\Pages\Policy;
use A2Insights\FilamentSaas\Features\Filament\Pages\Terms;
use A2Insights\FilamentSaas\Settings\reCAPTCHASettings;
use A2Insights\FilamentSaas\Settings\WebhooksSettings;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FeaturesServiceProvider extends PackageServiceProvider
{
    protected Features $features;

    public function configurePackage(Package $package): void
    {
        $package->name('filament-saas.features');

        Route::get('/terms-of-service', Terms::class)
            ->middleware('web')
            ->name('terms');

        Route::get('/privacy-policy', Policy::class)
            ->middleware('web')
            ->name('policy');
    }

    public function packageBooted(): void
    {
        parent::packageBooted();

        // return if running in the console
        if (App::runningInConsole()) {
            return;
        }

        $this->features = Cache::remember('filament-saas.features', now()->addHours(10), fn () => App::make(Features::class));

        Livewire::component('switch-language', SwitchLanguage::class);

        // TODO: Implement sync methods
        // $this->syncRegistration();
        // $this->sync2fa();
        $this->syncWebhooks();
        // $this->syncRecaptcha();
    }

    private function syncRecaptcha(): void
    {
        if ($this->features->recaptcha) {
            $recaptchaSettings = Cache::remember('filament-saas.recaptcha', now()->addHours(10), fn () => App::make(reCAPTCHASettings::class));

            // Prevents login page from breaking if recaptcha is enabled but no keys are set
            if (! $recaptchaSettings->site_key || ! $recaptchaSettings->secret_key) {
                return;
            }

            Config::set('captcha.sitekey', $recaptchaSettings->site_key);
            Config::set('captcha.secret', $recaptchaSettings->secret_key);
        }
    }

    private function syncRegistration(): void
    {
        Config::set('filament-breezy.enable_registration', $this->features->auth_registration);
    }

    private function sync2fa(): void
    {
        Config::set('filament-breezy.enable_2fa', $this->features->auth_2fa);
    }

    private function syncWebhooks(): void
    {
        if (! $this->features->webhooks) {
            Config::set('filament-webhook-server.pages', []);
            Config::set('filament-webhook-server.models', []);
        } else {
            $webhookSettings = Cache::remember('filament-saas.webhooks', now()->addHours(10), fn () => App::make(WebhooksSettings::class));

            Config::set('filament-webhook-server.models', $webhookSettings->models);
            Config::set('filament-webhook-server.polling', $webhookSettings->poll_interval);
            Config::set('filament-webhook-server.webhook.keep_history', $webhookSettings->history);
        }
    }
}
