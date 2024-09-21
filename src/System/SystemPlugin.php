<?php

namespace Octo\System;

use Filament\Contracts\Plugin;
use Filament\Facades\Filament;
use Filament\FilamentManager;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SystemPlugin implements Plugin
{
    protected $settings;

    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'octo.system';
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

    public function register(Panel $panel): void {}
}
