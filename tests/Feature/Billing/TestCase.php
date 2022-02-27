<?php

namespace Octo\Tests\Feature\Billing;

use App\View\Components\AppLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Laravel\Cashier\Cashier as StripeCashier;
use Octo\Billing\BillingPortal;
use Octo\Billing\Saas;
use Octo\OctoServiceProvider;
use Stripe\ApiResource;
use Stripe\Exception\InvalidRequestException;
use Stripe\Plan;
use Stripe\Product;
use Stripe\Stripe;
use Laravel\Jetstream\JetstreamServiceProvider;
use Livewire\LivewireServiceProvider;
use Octo\Billing\BillingServiceProvider;
use Octo\Tests\TestCase as TestsTestCase;

abstract class TestCase extends TestsTestCase
{
    protected static $productId;

    protected static $freeProductId;

    protected static $stripePlanId;

    protected static $stripeFreePlanId;


    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->resetDatabase();

        $this->loadLaravelMigrations(['--database' => 'sqlite']);

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        Blade::component(AppLayout::class, 'app-layout');

        Saas::plan('Monthly $10', static::$stripePlanId)
            ->price(10, 'USD')
            ->features([
                Saas::feature('Build Minutes', 'build.minutes', 3000),
                Saas::feature('Seats', 'teams', 10)->notResettable(),
            ]);

        Saas::plan('Free Plan', static::$stripeFreePlanId)
            ->features([
                Saas::feature('Build Minutes', 'build.minutes', 10),
                Saas::feature('Seats', 'teams', 5)->notResettable(),
            ]);

        BillingPortal::resolveBillable(function (Request $request) {
            return $request->user();
        });

        if (class_exists(StripeCashier::class)) {
            StripeCashier::useCustomerModel(Models\User::class);
        }

        BillingPortal::resolveAuthorization(function ($billable, Request $request) {
            return true;
        });
    }

    /**
     * {@inheritdoc}
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        Stripe::setApiKey(getenv('STRIPE_SECRET') ?: env('STRIPE_SECRET'));

        static::$stripePlanId = 'monthly-10-'.Str::random(10);

        static::$stripeFreePlanId = 'free-'.Str::random(10);

        static::$productId = 'product-1'.Str::random(10);

        static::$freeProductId = 'product-free'.Str::random(10);

        Product::create([
            'id' => static::$productId,
            'name' => 'Laravel Cashier Test Product',
            'type' => 'service',
        ]);

        Product::create([
            'id' => static::$freeProductId,
            'name' => 'Laravel Cashier Test Product',
            'type' => 'service',
        ]);

        Plan::create([
            'id' => static::$stripePlanId,
            'nickname' => 'Monthly $10',
            'currency' => 'USD',
            'interval' => 'month',
            'billing_scheme' => 'per_unit',
            'amount' => 1000,
            'product' => static::$productId,
        ]);

        Plan::create([
            'id' => static::$stripeFreePlanId,
            'nickname' => 'Free',
            'currency' => 'USD',
            'interval' => 'month',
            'billing_scheme' => 'per_unit',
            'amount' => 0,
            'product' => static::$freeProductId,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        static::deleteStripeResource(new Plan(static::$stripePlanId));
        static::deleteStripeResource(new Plan(static::$stripeFreePlanId));
    }

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            \Laravel\Cashier\CashierServiceProvider::class,
            OctoServiceProvider::class,
            LivewireServiceProvider::class,
            JetstreamServiceProvider::class,
            BillingServiceProvider::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'wslxrEFGWY6GfGhvN9L3wH3KSRJQQpBD');
        $app['config']->set('auth.providers.users.model', Models\User::class);
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'database' => __DIR__.'/database.sqlite',
            'prefix'   => '',
        ]);

        $app['config']->set('billing.middleware', [
            'web',
            \Octo\Billing\Http\Middleware\Authorize::class,
        ]);

        $app['config']->set('cashier.webhook.secret', null);

        $app['config']->set('jetstream.stack', 'livewire');
    }

    /**
     * Reset the database.
     *
     * @return void
     */
    protected function resetDatabase()
    {
        file_put_contents(__DIR__.'/database.sqlite', null);
    }

    /**
     * Create a new subscription.
     *
     * @param  \Octo\Billing\Test\Models\Stripe\User  $user
     * @param  \Octo\Billing\Plan  $plan
     * @return \Octo\Billing\Models\Stripe\Subscription
     */
    protected function createStripeSubscription($user, $plan)
    {
        $subscription = $user->newSubscription('main', $plan->getId());
        $meteredFeatures = $plan->getMeteredFeatures();

        if (! $meteredFeatures->isEmpty()) {
            foreach ($meteredFeatures as $feature) {
                $subscription->meteredPrice($feature->getMeteredId());
            }
        }

        return $subscription->create('pm_card_visa');
    }

    protected static function deleteStripeResource(ApiResource $resource)
    {
        try {
            $resource->delete();
        } catch (InvalidRequestException $e) {
            //
        }
    }
}


namespace App\View\Components;

use Illuminate\View\Component;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return <<<'blade'
            <div>
                {{ $slot }}
            </div>
        blade;
    }
}
