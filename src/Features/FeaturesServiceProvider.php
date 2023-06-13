<?php

namespace Octo\Features;

use Filament\PluginServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Octo\Features\Filament\Pages\FeaturesPage;
use Octo\Settings\reCAPTCHASettings;
use Spatie\LaravelPackageTools\Package;

class FeaturesServiceProvider extends PluginServiceProvider
{
    protected array $pages = [
        FeaturesPage::class,
    ];

    protected Features $features;

    public function configurePackage(Package $package): void
    {
        $package->name('octo.features');

        // Future we wiil integrate with laravel pennant
        // Feature::define('dark_mode');
    }

    public function packageBooted(): void
    {
        parent::packageBooted();

        // return if running in the console
        if (App::runningInConsole()) {
            return;
        }

        $this->features = App::make(Features::class);

        $this->syncDarkMode();
        $this->syncRegistration();
        $this->syncLogin();
        $this->sync2fa();
        $this->syncWebhooks();
        $this->syncRecaptcha();
    }

    private function syncRecaptcha(): void
    {
        if ($this->features->recaptcha) {
            $recaptchaSettings = App::make(reCAPTCHASettings::class);

            // Prevents login page from breaking if recaptcha is enabled but no keys are set
            if (! $recaptchaSettings->site_key || ! $recaptchaSettings->secret_key) {
                return;
            }

            Config::set('captcha.sitekey', $recaptchaSettings->site_key);
            Config::set('captcha.secret', $recaptchaSettings->secret_key);
        }
    }

    private function syncWebhooks(): void
    {
        // TODO: Implement syncWebhooks() method.
    }

    private function syncDarkMode(): void
    {
        Config::set('filament.dark_mode', $this->features->dark_mode);
        Config::set('notifications.dark_mode', $this->features->dark_mode);
    }

    private function syncRegistration(): void
    {
        Config::set('filament-breezy.enable_registration', $this->features->auth_registration);
    }

    private function syncLogin(): void
    {
        $pages = Config::get('filament.auth.pages');

        if ($this->features->auth_login) {
            $pages['login'] = \JeffGreco13\FilamentBreezy\Http\Livewire\Auth\Login::class;
        } else {
            unset($pages['login']);
        }

        Config::set('filament.auth.pages', $pages);
    }

    private function sync2fa(): void
    {
        Config::set('filament-breezy.enable_2fa', $this->features->auth_2fa);
    }
}
