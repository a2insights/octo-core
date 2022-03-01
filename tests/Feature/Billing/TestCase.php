<?php

namespace Octo\Tests\Feature\Billing;

use App\View\Components\AppLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Laravel\Cashier\Cashier as StripeCashier;
use Octo\Billing\Billing;
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
use Stripe\Price;

abstract class TestCase extends TestsTestCase
{
    protected static $productId;

    protected static $freeProductId;

    protected static $stripeMonthlyPlanId;

    protected static $stripeMeteredPriceId;

    protected static $stripeYearlyPlanId;

    protected static $stripeFreePlanId;

    protected static $stripePlanId;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        if (!env('BILLING_TESTS', false)) {
            $this->markTestSkipped('Billing tests are disabled. Set BILLING_TESTS=true to run them.');
        }

        parent::setUp();

        Saas::clearPlans();

        Saas::cleanSyncUsageCallbacks();

        $this->resetDatabase();

        $this->loadLaravelMigrations(['--database' => 'sqlite']);

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        Blade::component(AppLayout::class, 'app-layout');

        $freeStripePlan = Saas::plan('Free Plan', static::$stripeFreePlanId, static::$stripeYearlyPlanId, static::$stripePlanId)
            ->features([
                Saas::feature('Build Minutes', 'build.minutes', 10),
                Saas::feature('Seats', 'teams', 5)->notResettable(),
            ]);

        Saas::plan('Monthly $10', static::$stripeMonthlyPlanId)
            ->inheritFeaturesFromPlan($freeStripePlan, [
                Saas::feature('Build Minutes', 'build.minutes', 3000),
                Saas::meteredFeature('Metered Build Minutes', 'metered.build.minutes', 3000)
                    ->meteredPrice(static::$stripeMeteredPriceId, 0.1, 'minute'),
                Saas::feature('Seats', 'teams', 10)->notResettable(),
                Saas::feature('Mails', 'mails', 300),
            ]);

        Saas::plan('Yearly $100', static::$stripeYearlyPlanId)
            ->inheritFeaturesFromPlan($freeStripePlan, [
                Saas::feature('Build Minutes', 'build.minutes')->unlimited(),
                Saas::feature('Seats', 'teams', 10)->notResettable(),
            ]);

        Saas::plan('Yearly $100', static::$stripePlanId)
            ->inheritFeaturesFromPlan($freeStripePlan, [
                Saas::feature('Build Minutes', 'build.minutes')->unlimited(),
                Saas::feature('Seats', 'teams', 1770)->notResettable(),
            ]);

        Billing::resolveBillable(function (Request $request) {
            return $request->user();
        });

        StripeCashier::useCustomerModel(Models\User::class);

        Billing::resolveAuthorization(function ($billable, Request $request) {
            return true;
        });
    }

    /**
     * {@inheritdoc}
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        if (!env('BILLING_TESTS', false)) {
            return;
        }

        Stripe::setApiKey(getenv('STRIPE_SECRET') ?: env('STRIPE_SECRET'));

        static::$freeProductId = Product::create([
            'name' => 'Laravel Cashier Test Free Product',
            'type' => 'service',
        ])->id;

        static::$productId = Product::create([
            'name' => 'Laravel Cashier Test Product',
            'type' => 'service',
        ])->id;

        static::$stripeFreePlanId = Plan::create([
            'nickname' => 'Free',
            'currency' => 'USD',
            'interval' => 'month',
            'billing_scheme' => 'per_unit',
            'amount' => 0,
            'product' => static::$freeProductId,
        ])->id;

        static::$stripeMonthlyPlanId = Plan::create([
            'nickname' => 'Monthly $10',
            'currency' => 'USD',
            'interval' => 'month',
            'billing_scheme' => 'per_unit',
            'amount' => 1000,
            'product' => static::$productId,
        ])->id;

        static::$stripeYearlyPlanId = Plan::create([
            'nickname' => 'Yearly $100',
            'currency' => 'USD',
            'interval' => 'year',
            'billing_scheme' => 'per_unit',
            'amount' => 10000,
            'product' => static::$productId,
        ])->id;

        static::$stripePlanId = Plan::create([
            'nickname' => 'Plan',
            'currency' => 'USD',
            'interval' => 'month',
            'billing_scheme' => 'per_unit',
            'amount' => 1200,
            'product' => static::$productId,
        ])->id;

        static::$stripeFreePlanId = Plan::create([
            'nickname' => 'Free',
            'currency' => 'USD',
            'interval' => 'month',
            'billing_scheme' => 'per_unit',
            'amount' => 0,
            'product' => static::$productId,
        ])->id;

        static::$stripeMeteredPriceId = Price::create([
            'nickname' => 'Monthly Metered $0.01 per unit',
            'currency' => 'USD',
            'recurring' => [
                'interval' => 'month',
                'usage_type' => 'metered',
            ],
            'unit_amount' => 1,
            'product' => static::$productId,
        ])->id;
    }

    /**
    * {@inheritdoc}
    */
    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        if (!env('BILLING_TESTS', false)) {
            return;
        }

        static::deleteStripeResource(new Plan(static::$stripeMonthlyPlanId));
        static::deleteStripeResource(new Plan(static::$stripeYearlyPlanId));
        static::deleteStripeResource(new Plan(static::$stripeFreePlanId));
        static::deleteStripeResource(new Plan(static::$stripePlanId));
        static::deleteStripeResource(new Product(static::$productId));
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
        parent::getEnvironmentSetUp($app);

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
     * @return \Octo\Billing\Models\Subscription
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
