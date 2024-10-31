<?php

namespace Octo\Features;

use Filament\Contracts\Plugin;
use Filament\Facades\Filament;
use Filament\FilamentManager;
use Filament\Panel;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Octo\Features\Filament\Pages\FeaturesPage;

class FeaturesPlugin implements Plugin
{
    protected Features $features;

    public static function make(): static
    {

        return App::make(static::class);
    }

    public function getId(): string
    {
        return 'octo.features';
    }

    /**
     * Class MyClass overrides inline block form.
     */
    public static function get(): Plugin|FilamentManager
    {
        return filament(App::make(static::class)->getId());
    }

    public function boot(Panel $panel): void
    {
        if (App::runningInConsole()) {
            return;
        }

        $this->features = Cache::remember('octo.features', now()->addHours(10), fn () => app(Features::class));
        $switchLanguage = $this->features->switch_language;
        if ($switchLanguage) {
            Filament::registerRenderHook(
                PanelsRenderHook::USER_MENU_BEFORE,
                fn (): string => Blade::render("@livewire('switch-language')")
            );
        }

        // $this->features = App::make(Features::class);

        // TODO: dark_mode configurable not work with hasnayeen themes
        // $panel->darkMode($this->features->dark_mode);
    }

    public function register(Panel $panel): void
    {
        $panel->pages([
            FeaturesPage::class,
        ]);
    }
}
