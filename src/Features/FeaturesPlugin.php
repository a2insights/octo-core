<?php

namespace Octo\Features;

use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Contracts\Plugin;
use Filament\FilamentManager;
use Filament\Panel;
use Illuminate\Support\Facades\App;
use Octo\Features\Filament\Pages\FeaturesPage;
use Octo\User\Filament\Pages\Register;

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

        //$this->features = App::make(Features::class);

        // TODO: dark_mode not work with hasnayeen themes
        // $panel->darkMode($this->features->dark_mode);

    }

    public function register(Panel $panel): void
    {
        if (! Utils::isResourcePublished()) {
            $panel->pages([
                FeaturesPage::class,
            ]);

            $panel->registration(Register::class);
        }
    }
}
