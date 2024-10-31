<?php

namespace Octo\User;

use Filament\Contracts\Plugin;
use Filament\FilamentManager;
use Filament\Panel;
use Octo\User\Filament\UserResource;

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

    public function boot(Panel $panel): void {}

    public function register(Panel $panel): void
    {
        $panel->resources([
            config('octo.users.resource', UserResource::class),
        ]);
    }
}
