<?php

namespace Octo;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Octo\Resources\Blade\PhoneInput;
use Octo\Resources\Blade\Sidebar;
use Octo\Resources\Livewire\Notifications\DropdownNotifications;
use Octo\Resources\Livewire\Notifications\ListNotifications;
use Octo\Resources\Livewire\Subscribe;
use Laravel\Cashier\Cashier as StripeCashier;
use Octo\Billing\Http\Livewire\ListPaymentMethods;
use Octo\Billing\Http\Livewire\PlansSlide;
use Octo\Resources\Livewire\System\ListUsers;
use Octo\Resources\Livewire\SwitchDashboard;

class OctoServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (class_exists(StripeCashier::class)) {
            StripeCashier::useSubscriptionModel(\Octo\Billing\Models\Stripe\Subscription::class);
        }

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'octo');

        $this->publishes([
            __DIR__.'/../config/octo.php' => config_path('octo.php'),
        ], 'octo-config');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'octo');

        // Octo blade
        Blade::component(Sidebar::class, 'octo-sidebar');
        Blade::component(PhoneInput::class, 'octo-phone-input');
        Blade::component('octo::blade.hero', 'octo-hero');
        Blade::component('octo::blade.tile', 'octo-tile');

        // Billing
        Livewire::component('plans-slide', PlansSlide::class);
        Livewire::component('switch-dashboard', SwitchDashboard::class);
        Livewire::component('list-payment-methods', ListPaymentMethods::class);

        // Need publish
        Blade::component('footer', 'footer');

        // Livewire
        Livewire::component('octo-subscribe', Subscribe::class);
        Livewire::component('octo-dropdown-notifications', DropdownNotifications::class);
        Livewire::component('octo-list-notifications', ListNotifications::class);

        // System
        Livewire::component('octo-system-list-users', ListUsers::class);

        // Configure commmands
        $this->commands([
            Console\InstallCommand::class,
            Console\InstallSmsDriverCommand::class,
            Console\UninstallSmsDriverCommand::class,
        ]);

        Route::group([], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/octo.php');
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/octo.php', 'octo');
        $this->mergeConfigFrom(__DIR__.'/../config/services.php', 'services');
    }
}
