<?php

namespace Octo;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Octo\Listeners\WelcomeUserNotification;
use Octo\Listeners\WelcomeUserQueuedNotification;
use Octo\Resources\Blade\PhoneInput;
use Octo\Resources\Blade\Sidebar;
use Octo\Resources\Livewire\Notifications\DropdownNotifications;
use Octo\Resources\Livewire\Notifications\ListNotifications;
use Octo\Resources\Livewire\Subscribe;
use Laravel\Cashier\Cashier as StripeCashier;
use Laravel\Paddle\Cashier as PaddleCashier;
use Octo\Billing\Http\Livewire\ListPaymentMethods;
use Octo\Billing\Http\Livewire\PlansSlide;

class OctoServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (class_exists(StripeCashier::class)) {
            StripeCashier::useSubscriptionModel(\Octo\Billing\Models\Stripe\Subscription::class);
        }

        if (class_exists(PaddleCashier::class)) {
            PaddleCashier::useSubscriptionModel(\Octo\Billing\Models\Paddle\Subscription::class);
        }

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'octo');

        $this->publishes([
            __DIR__.'/../config/octo.php' => config_path('octo.php'),
        ], 'octo-config');

        $this->publishes([
            __DIR__.'/../database/migrations/2014_10_12_000000_create_users_table.php' => database_path('migrations/2014_10_12_000000_create_users_table.php'),
        ], 'octo-migrations');

        $this->publishes([
            __DIR__.'/../database/migrations/2020_01_01_000001_create_subscription_usages_table.php' => database_path('migrations/2014_10_12_000000_create_users_table.php'),
        ], 'octo-migrations');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'octo');

        // Octo blade
        Blade::component(Sidebar::class, 'octo-sidebar');
        Blade::component(PhoneInput::class, 'octo-phone-input');
        Blade::component('octo::blade.hero', 'octo-hero');
        Blade::component('octo::blade.tile', 'octo-tile');

        // Billing
        Livewire::component('plans-slide', PlansSlide::class);
        Livewire::component('list-payment-methods', ListPaymentMethods::class);

        // Need publish
        Blade::component('footer', 'footer');

        // Livewire
        Livewire::component('octo-subscribe', Subscribe::class);
        Livewire::component('octo-dropdown-notifications', DropdownNotifications::class);
        Livewire::component('octo-list-notifications', ListNotifications::class);

        // Configure commmands
        $this->commands([
            Console\InstallCommand::class,
            Console\InstallSmsDriverCommand::class,
            Console\UninstallSmsDriverCommand::class,
        ]);

        Broadcast::channel('user-notification.{userId}', function ($user, $userId){
            return $user->id === (int) $userId;
        });

        Route::group([], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/octo.php');
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/octo.php', 'octo');
        $this->mergeConfigFrom(__DIR__.'/../config/services.php', 'services');

        if (Features::hasWelcomeUserFeatures()) {
            if (Features::queuedWelcomeUserNotifications()) {
                Event::listen(
                    Registered::class,
                    [WelcomeUserQueuedNotification::class, 'handle']
                );
            }

            if (!Features::queuedWelcomeUserNotifications()) {
                Event::listen(
                    Registered::class,
                    [WelcomeUserNotification::class, 'handle']
                );
            };
        }
    }
}
