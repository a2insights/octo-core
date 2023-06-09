<?php

namespace Octo\Settings;

use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Filament\PluginServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Livewire\Livewire;
use Octo\Settings\Filament\Components\SwitchLanguage;
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
                ->url('/dashboard/settings/main')
                ->icon('heroicon-s-cog'),
        ];
    }

    public function packageBooted(): void
    {
        parent::packageBooted();

        // return if running in the console
        if (App::runningInConsole()) {
            return;
        }

        Livewire::component('switch-language', SwitchLanguage::class);
        Filament::registerRenderHook(
            'global-search.end',
            fn (): string => Blade::render("@livewire('switch-language')")
        );

        $this->settings = App::make(Settings::class);

        $this->syncFavicon();
        $this->syncMetadata();
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

    private function syncMetadata(): void
    {
        $name = $this->settings->name;
        $description = $this->settings->description;
        $keywords = $this->settings->keywords;

        if ($name) {
            Config::set('filament.brand', $name);
        }

        if ($description) {
            Filament::pushMeta([
                new HtmlString('<meta name="description" content="'.$description.'">'),
            ]);
        }

        if ($keywords) {
            Filament::pushMeta([
                new HtmlString('<meta name="keywords" content="'.implode(',', $keywords).'">'),
            ]);
        }
    }

    private function syncFavicon(): void
    {
        $favicon = $this->settings->favicon;

        if ($favicon) {
            Config::set('filament.favicon', Storage::url($favicon));
        }
    }
}
