<?php

namespace Octo\User;

use Filament\PluginServiceProvider;
use Octo\User\Filament\Widgets\UsersChart;
use Octo\User\Filament\Widgets\UsersOverview;
use Octo\User\Filament\UserResource;
use Spatie\LaravelPackageTools\Package;
use App\Models\User;

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
