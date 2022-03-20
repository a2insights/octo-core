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

        Saas::plan('Free', 'price_1JgbF1KBVLqcMf8uOBf7NYAF')
            ->monthly(0)
            ->features([
                Saas::feature('1 Team', 'teams', 1, Team::class)->notResettable(),
                Saas::feature('50 Contacts', 'contacts', 50, Contact::class)->notResettable(),
            ]);

        Saas::plan('Starter', 'price_1IriI3KBVLqcMf8ufdEbBfEp')
            ->monthly(5)
            ->features([
                Saas::feature('2 Teams', 'teams', 2, Team::class)->notResettable(),
                Saas::feature('100 Contacts', 'contacts', 100, Contact::class, fn () => 1)->notResettable(),
            ]);

        Saas::plan('Prime', 'price_1Jh22oKBVLqcMf8ufFUi7upc')
            ->monthly(10)
            ->features([
                Saas::feature('5 Teams', 'teams', 5, Team::class)->notResettable(),
                Saas::feature('Unlimited contacts', 'contacts', Contact::class)->unlimited()->notResettable(),
                Saas::meteredFeature('100 Sms', 'metered.sms.units', 100)
                    ->meteredPrice('price_1KaSu9KBVLqcMf8ucfnWDtB2', 1, 'unit')
            ]);
    }
}
