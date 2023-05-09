<?php

namespace Octo\Settings;

use Filament\Navigation\UserMenuItem;
use Filament\PluginServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Octo\Settings\Filament\Pages\MainSettingsPage;
use Spatie\LaravelPackageTools\Package;

class SettingsServiceProvider extends PluginServiceProvider
{
    protected array $pages = [
        MainSettingsPage::class,
    ];

    protected Settings $settings;

    public function configurePackage(Package $package): void
    {
        $package->name('octo.settings');
    }

    protected function getUserMenuItems(): array
    {
        return [
            UserMenuItem::make()
                ->label('Settings')
                ->url('/settings/main')
                ->icon('heroicon-s-cog'),
        ];
    }

    public function packageBooted(): void
    {
        parent::packageBooted();

        $this->settings = App::make(Settings::class);

        // return if running in the console
        if (App::runningInConsole()) {
            return;
        }

        $this->syncDarkMode();
        $this->syncRegistration();
        $this->syncLogin();
        $this->syncFavicon();

        // Register middleware to restrict ip access from settings
        $this->app['Illuminate\Contracts\Http\Kernel']->prependMiddleware(\Octo\Settings\Http\Middleware\RestrictIps::class);
    }

    protected function syncFavicon(): void
    {
        $favicon = $this->settings->favicon;

        if ($favicon) {
            Config::set('filament.favicon', Storage::url($favicon));
        }
    }

    private function syncDarkMode(): void
    {
        Config::set('filament.dark_mode', $this->settings->dark_mode);
    }

    private function syncRegistration(): void
    {
        Config::set('filament-breezy.enable_registration', $this->settings->auth_registration);
    }

    private function syncLogin(): void
    {
        $loginEnabled = $this->settings->auth_login;

        $pages = Config::get('filament.auth.pages');

        if ($loginEnabled) {
            $pages['login'] = \JeffGreco13\FilamentBreezy\Http\Livewire\Auth\Login::class;
        } else {
            unset($pages['login']);
        }

        Artisan::call('route:clear');

        Config::set('filament.auth.pages', $pages);
    }
}
