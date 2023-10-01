<?php

namespace Octo\User;

use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Contracts\Plugin;
use Filament\FilamentManager;
use Filament\Panel;
use Octo\User\Filament\UserResource;
use Octo\User\Filament\Widgets\UsersChart;
use Octo\User\Filament\Widgets\UsersOverview;

class UserPlugin implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'octo.user';
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
    }

    public function register(Panel $panel): void
    {

        if (! Utils::isResourcePublished()) {
            $panel->resources([
                UserResource::class,
            ])->widgets([
                UsersOverview::class,
                UsersChart::class,
            ]);
        }
    }
}
