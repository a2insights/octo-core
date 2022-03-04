<?php
namespace Octo\Common;

use Filament\PluginServiceProvider;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;
use Octo\Common\Http\Livewire\DropdownNotifications;
use Octo\Common\Http\Livewire\ListNotifications;
use Octo\Common\Http\Livewire\Subscribe;
use Octo\Common\View\Components\PhoneInput;
use Octo\Common\View\Components\Sidebar;
use Spatie\LaravelPackageTools\Package;

class CommonServiceProvider extends PluginServiceProvider
{
    public function boot()
    {
        parent::boot();

        Blade::component(Sidebar::class, 'octo-sidebar');
        Blade::component(PhoneInput::class, 'octo-phone-input');
        Blade::component('octo::components.tile', 'octo-tile');
        Blade::component('octo::components.card-count', 'octo-card-count');
        Blade::component('octo::components.slide-over', 'octo-slide-over');
        Blade::component('footer', 'footer');

        Livewire::component('octo-subscribe', Subscribe::class);
        Livewire::component('octo-dropdown-notifications', DropdownNotifications::class);
        Livewire::component('octo-list-notifications', ListNotifications::class);
    }

    public function configurePackage(Package $package): void
    {
        $package->name('octo.common');
    }
}
