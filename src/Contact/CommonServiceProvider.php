<?php
namespace Octo\Contact;

use Filament\PluginServiceProvider;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;
use Octo\Common\Http\Livewire\DropdownNotifications;
use Octo\Common\Http\Livewire\ListNotifications;
use Octo\Contact\Filament\ContactResource;
use Spatie\LaravelPackageTools\Package;

class CommonServiceProvider extends PluginServiceProvider
{
    protected array $resources = [
        ContactResource::class,
    ];

    public function boot()
    {
        parent::boot();

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

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
