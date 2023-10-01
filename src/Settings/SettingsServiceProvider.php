<?php

namespace Octo\Settings;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Livewire\Livewire;
use Octo\Settings\Filament\Components\SwitchLanguage;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SettingsServiceProvider extends PackageServiceProvider
{
    protected Settings $settings;

    public function configurePackage(Package $package): void
    {
        $package->name('octo.settings');
    }

    public function packageBooted(): void
    {
        parent::packageBooted();

        // return if running in the console
        if (App::runningInConsole()) {
            return;
        }

        Livewire::component('switch-language', SwitchLanguage::class);

        $this->settings = App::make(Settings::class);

        $this->syncName();
        $this->syncTimezone();
    }

    private function syncTimezone(): void
    {
        $timezone = $this->settings->timezone;

        if ($timezone) {
            Config::set('app.timezone', $timezone);
            date_default_timezone_set($timezone);
        }
    }

    private function syncName(): void
    {
        $name = $this->settings->name;
        // $description = $this->settings->description;
        // $keywords = $this->settings->keywords;

        if ($name) {
            Config::set('filament.brand', $name);
            Config::set('app.name', $name);
        }
    }
}
