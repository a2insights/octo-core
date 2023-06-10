<?php

namespace Octo\User;

use App\Models\User;
use Filament\PluginServiceProvider;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Octo\User\Filament\Pages\BannedUser;
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

        Livewire::component(BannedUser::getName(), BannedUser::class);

        Route::get('banned/user', BannedUser::class)
            ->middleware('web')
          //  ->middleware(['throttle:6,1', 'auth:'.config('filament.auth.guard')])
            ->name('banned.user');
    }

    public function configurePackage(Package $package): void
    {
        $package->name('octo.user');
    }
}
