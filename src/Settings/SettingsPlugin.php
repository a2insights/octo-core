<?php

namespace Octo\Settings;

use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Contracts\Plugin;
use Filament\FilamentManager;
use Filament\Panel;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Octo\Settings\Filament\Pages\MainSettingsPage;

class SettingsPlugin implements Plugin
{
    protected Settings $settings;

    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'octo.settings';
    }

    /**
     * Class MyClass overrides inline block form.
     *
     * @phpstan-ignore-next-line */
    public static function get(): Plugin|FilamentManager
    {
        return filament(app(static::class)->getId());
    }

    public function boot(Panel $panel): void
    {
        if (App::runningInConsole()) {
            return;
        }

        $this->settings = Cache::remember('octo.settings', now()->addHours(10), fn () => app(Settings::class));

        $favicon = $this->settings->favicon;
        $logo = $this->settings->logo;
        $logoSize = $this->settings->logo_size;

        if ($favicon) {
            $panel->favicon(Storage::url($favicon));
        }

        if ($logo) {
            $panel->brandLogo(Storage::url($logo));
        }

        if ($logoSize) {
            $panel->brandLogoHeight($logoSize);
        }
    }

    public function register(Panel $panel): void
    {
        if (! Utils::isResourcePublished()) {
            $panel->pages([
                MainSettingsPage::class,
            ]);
        }
    }
}
