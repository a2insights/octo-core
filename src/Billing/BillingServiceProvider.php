<?php

namespace Octo\Billing;

use App\Models\Team;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
use Livewire\Livewire;
use Octo\Billing\Actions\HandleSubscriptions;
use Octo\Billing\Billing;
use Octo\Billing\Http\Livewire\ListPaymentMethods;
use Octo\Billing\Http\Livewire\PlansSlide;
use Octo\Marketing\Models\Contact;

class BillingServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        Livewire::component('plans-slide', PlansSlide::class);
        Livewire::component('list-payment-methods', ListPaymentMethods::class);

        Cashier::useSubscriptionModel(\Octo\Billing\Models\Subscription::class);

        Billing::dontProrateOnSwap();

        Billing::handleSubscriptionsUsing(HandleSubscriptions::class);

        Saas::currency('BRL');

        Saas::plan('Free', config('octo.free-plan-price-id', null))
            ->monthly(0)
            ->features([
                Saas::feature('1 Team', 'teams', 1, Team::class)->notResettable(),
                Saas::feature('50 Contacts', 'contacts', 50, Contact::class)->notResettable(),
            ]);

        // You can register your own plans like this:

        /*  Saas::plan('Free', '')
             ->monthly(0)
             ->features([
                 Saas::feature('1 Team', 'teams', 1, Team::class)->notResettable(),
                 Saas::feature('50 Contacts', 'contacts', 50, Contact::class)->notResettable(),
                 Saas::meteredFeature('10.000 Mails', 'metered.mails.units', 10000)
                     ->meteredPrice('price_1Kh0OzKBVLqcMf8uHJWWnhfi', 0.1, 'unit')
             ]);
          Saas::plan('Starter', 'price_1KhNitKBVLqcMf8uDO3LHE2r')
              ->monthly(30)
              ->features([
                  Saas::feature('5 Teams', 'teams', 5, Team::class)->notResettable(),
                  Saas::feature('10.000 Contacts', 'contacts', 10000, Contact::class, fn () => 1)->notResettable(),
                  Saas::meteredFeature('50.000 Mails', 'metered.mails.units', 50000)
                      ->meteredPrice('price_1KhNitKBVLqcMf8uD3XIo5eu', 0.01, 'unit')
              ]);
          Saas::plan('Prime', 'price_1KhNnSKBVLqcMf8u5Gj5649E')
              ->monthly(120)
              ->features([
                  Saas::feature('5 Teams', 'teams', 5, Team::class)->notResettable(),
                  Saas::feature('Unlimited contacts', 'contacts', Contact::class)->unlimited()->notResettable(),
                  Saas::meteredFeature('150.000 Mails', 'metered.mails.units', 150000)
                      ->meteredPrice('price_1KhNnSKBVLqcMf8uh8HjVyNC', 0.002, 'unit')
              ]); */
    }
}
