<?php

namespace Octo\Settings;

use Filament\Facades\Filament;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
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
        // Register middleware to restrict ip access from settings
        $this->app['Illuminate\Contracts\Http\Kernel']->prependMiddleware(\Octo\Settings\Http\Middleware\RestrictIps::class);

        // credits: https://github.com/bezhanSalleh/filament-language-switch/blob/65192edd4ca0e2e4dd35e5b78d1912760585a29e/src/FilamentLanguageSwitchServiceProvider.php#L33
        $middlewareStack = config('filament.middleware.base');
        $switchLanguageIndex = array_search(\Octo\Settings\Http\Middleware\Locale::class, $middlewareStack);
        $dispatchServingFilamentEventIndex = array_search(DispatchServingFilamentEvent::class, $middlewareStack);

        if ($switchLanguageIndex === false || $switchLanguageIndex > $dispatchServingFilamentEventIndex) {

            $middlewareStack = array_filter($middlewareStack, function ($middleware) {
                return $middleware !== \Octo\Settings\Http\Middleware\Locale::class;
            });

            array_splice($middlewareStack, $dispatchServingFilamentEventIndex, 0, [\Octo\Settings\Http\Middleware\Locale::class]);

            config(['filament.middleware.base' => $middlewareStack]);
        }

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

        $this->syncDarkMode();
        $this->syncRegistration();
        $this->syncLogin();
        $this->syncFavicon();
        $this->syncMetadata();
        $this->sync2fa();
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

    private function sync2fa(): void
    {
        Config::set('filament-breezy.enable_2fa', $this->settings->auth_2fa);
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
        $pages = Config::get('filament.auth.pages');

        if ($this->settings->auth_login) {
            $pages['login'] = \JeffGreco13\FilamentBreezy\Http\Livewire\Auth\Login::class;
        } else {
            unset($pages['login']);
        }

        Config::set('filament.auth.pages', $pages);
    }
}
