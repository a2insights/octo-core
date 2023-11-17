<?php

namespace Octo\Settings;

use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Contracts\Plugin;
use Filament\Facades\Filament;
use Filament\FilamentManager;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Octo\Settings\Filament\Pages\MainSettingsPage;

class SettingsPlugin implements Plugin
{
    protected $settings;

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

        $this->settings = Cache::remember('octo.settings', now()->addHours(4), function () {
            return app(Settings::class);
        });

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

        Filament::registerRenderHook(
            'panels::global-search.end',
            fn (): string => Blade::render("@livewire('switch-language')")
        );

        Filament::serving(function () {
            $navigation = [
                'super_admin' => [
                    [
                        NavigationItem::make('Logs')
                            ->url(config('log-viewer.route_path'))
                            ->icon('iconpark-log')
                            ->group('System'),
                    ],
                ],
            ];

            $isSuperAdmin = Auth::user()?->hasRole('super_admin');

            collect($navigation['super_admin'])->each(fn ($items) => $isSuperAdmin ? Filament::registerNavigationItems($items) : null);
        });
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
