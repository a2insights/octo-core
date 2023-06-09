<?php

namespace Octo\User;

use App\Models\User;
use Filament\PluginServiceProvider;
use Octo\User\Filament\UserResource;
use Octo\User\Filament\Widgets\UsersChart;
use Octo\User\Filament\Widgets\UsersOverview;
use Spatie\LaravelPackageTools\Package;

class UserServiceProvider extends PluginServiceProvider
{
    protected array $resources = [
        UserResource::class,
    ];

    protected array $widgets = [
        UsersOverview::class,
        UsersChart::class,
    ];

    public function bootingPackage(): void
    {
        User::observe(UserObserver::class);
    }

    public function configurePackage(Package $package): void
    {
        $package->name('octo.user');
    }
}
