<?php

namespace Octo\Features;

use Filament\Navigation\UserMenuItem;
use Filament\PluginServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Octo\Features\Filament\Pages\FeaturesPage;
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

    protected function getUserMenuItems(): array
    {
        return [
            UserMenuItem::make()
                ->label('Features')
                ->url('/dashboard/features')
                ->icon('heroicon-o-view-grid-add'),
        ];
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
    }

    private function syncDarkMode(): void
    {
        Config::set('filament.dark_mode', $this->features->dark_mode);
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
