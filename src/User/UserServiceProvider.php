<?php

namespace Octo\User;

use App\Models\User;
use Filament\Facades\Filament;
use Filament\PluginServiceProvider;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Octo\User\Filament\Pages\BannedUser;
use Octo\User\Filament\Pages\Login;
use Octo\User\Filament\Pages\Register;
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
        Livewire::component(Login::getName(), Login::class);
        Livewire::component(Register::getName(), Register::class);

        Route::get('banned/user', BannedUser::class)
            ->middleware('web')
            ->name('banned.user');

        // Fix recaptcha style
        Filament::registerRenderHook(
            'body.start',
            fn (): string => '<style>.g-recaptcha { margin: 0 auto;display: table }</style>'
        );

    }

    public function configurePackage(Package $package): void
    {
        $package->name('octo.user');
    }
}
