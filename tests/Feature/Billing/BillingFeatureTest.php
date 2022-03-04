<?php

namespace Octo\Tests\Feature\Billing;

use Carbon\Carbon;
use Laravel\Cashier\Subscription;
use Octo\Billing\Feature;
use Octo\Billing\Saas;
use Octo\Tests\Feature\Billing\Models\User;
use Stripe\ApiResource;
use Stripe\Exception\InvalidRequestException;
use Stripe\Stripe;

class BillingFeatureTest extends TestCase
{
    /**
     * Delete the given Stripe resource.
     *
     * @param  \Stripe\ApiResource  $resource
     * @return void
     */
    protected static function deleteStripeResource(ApiResource $resource)
    {
        try {
            $resource->delete();
        } catch (InvalidRequestException $e) {
            //
        }
    }

    /**
     * Create a new subscription.
     */
    protected function createSubscription($user, $plan)
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

    public function test_record_feature_usage()
    {
        $user = User::factory()->create();

        $plan = Saas::getPlan(static::$billingMonthlyPlanId);

        $subscription = $this->createSubscription($user, $plan);

        $subscription->recordFeatureUsage('build.minutes', 50);

        $this->assertEquals(50, $subscription->getUsedQuota('build.minutes'));

        $this->assertEquals(
            2950,
            $subscription->getRemainingQuota('build.minutes')
        );
    }

    public function test_set_feature_usage()
    {
        $user = User::factory()->create();

        $plan = Saas::getPlan(static::$billingMonthlyPlanId);

        $subscription = $this->createSubscription($user, $plan);

        $subscription->recordFeatureUsage('build.minutes', 50);

        $subscription->setFeatureUsage('build.minutes', 20);

        $this->assertEquals(
            20,
            $subscription->getUsedQuota('build.minutes')
        );

        $this->assertEquals(
            2980,
            $subscription->getRemainingQuota('build.minutes')
        );
    }

    public function test_reduce_feature_usage()
    {
        $user = User::factory()->create();

        $plan = Saas::getPlan(static::$billingMonthlyPlanId);

        $subscription = $this->createSubscription($user, $plan);

        $subscription->recordFeatureUsage('build.minutes', 50);

        $this->assertEquals(
            50,
            $subscription->getUsedQuota('build.minutes')
        );

        $subscription->decrementFeatureUsage('build.minutes', 55);

        $this->assertEquals(
            3000,
            $subscription->getRemainingQuota('build.minutes')
        );
    }

    public function test_reduce_feature_usage_without_usage()
    {
        $user = User::factory()->create();

        $plan = Saas::getPlan(static::$billingMonthlyPlanId);

        $subscription = $this->createSubscription($user, $plan);

        $subscription->decrementFeatureUsage('build.minutes', 55);

        $this->assertEquals(
            3000,
            $subscription->getRemainingQuota('build.minutes')
        );
    }

    public function test_feature_usage_on_reset()
    {
        $user = User::factory()->create();

        $plan = Saas::getPlan(static::$billingMonthlyPlanId);

        $subscription = $this->createSubscription($user, $plan);

        $subscription->recordFeatureUsage('build.minutes', 50);

        $this->assertEquals(
            50,
            $subscription->getUsedQuota('build.minutes')
        );

        $subscription->resetQuotas();

        $this->assertEquals(
            0,
            $subscription->getUsedQuota('build.minutes')
        );

        $this->assertEquals(
            3000,
            $subscription->getRemainingQuota('build.minutes')
        );
    }

    public function test_feature_usage_on_resetting_not_resettable()
    {
        $user = User::factory()->create();

        $plan = Saas::getPlan(static::$billingMonthlyPlanId);

        $subscription = $this->createSubscription($user, $plan);

        $subscription->recordFeatureUsage('teams', 1);

        $this->assertEquals(
            1,
            $subscription->getUsedQuota('teams')
        );

        $subscription->resetQuotas();

        $this->assertEquals(
            1,
            $subscription->getUsedQuota('teams')
        );

        $this->assertEquals(
            9,
            $subscription->getRemainingQuota('teams')
        );
    }

    public function test_record_inexistent_feature_usage()
    {
        $user = User::factory()->create();

        $plan = Saas::getPlan(static::$billingMonthlyPlanId)
            ->features([]);

        $subscription = $this->createSubscription($user, $plan);

        $subscription->recordFeatureUsage('build.minutes', 50);

        $this->assertEquals(
            0,
            $subscription->getUsedQuota('build.minutes')
        );

        $this->assertEquals(
            0,
            $subscription->getRemainingQuota('build.minutes')
        );
    }

    public function test_plan_with_feature_to_array()
    {
        $user = User::factory()->create();

        $plan = Saas::getPlan(static::$billingMonthlyPlanId);

        $this->assertTrue(
            is_array($plan->toArray())
        );

        $this->assertTrue(
            is_array($plan->toArray()['features'])
        );
    }

    public function test_feature_usage_not_resettable()
    {
        $user = User::factory()->create();

        $plan = Saas::getPlan(static::$billingMonthlyPlanId);

        $subscription = $this->createSubscription($user, $plan);

        $subscription->recordFeatureUsage('teams', 5);

        $this->assertEquals(
            5,
            $subscription->getUsedQuota('teams')
        );

        Carbon::setTestNow(now()->addMonths(1));

        $this->assertEquals(
            5,
            $subscription->getUsedQuota('teams')
        );

        $this->assertEquals(
            5,
            $subscription->getRemainingQuota('teams')
        );
    }

    public function test_feature_usage_over_the_amount()
    {
        $user = User::factory()->create();

        $plan = Saas::getPlan(static::$billingMonthlyPlanId);

        $subscription = $this->createSubscription($user, $plan);

        $overQuota = 'not_set';

        $subscription->recordFeatureUsage('teams', 11, true, function ($feature, $valueOverQuota, $subscription) use (&$overQuota) {
            $overQuota = $valueOverQuota;
        });

        $this->assertEquals(1, $overQuota);
    }

    public function test_feature_usage_over_the_amount_increments_total_usage_correctly()
    {
        $user = User::factory()->create();

        $plan = Saas::getPlan(static::$billingMonthlyPlanId);

        $subscription = $this->createSubscription($user, $plan);

        $subscription->recordFeatureUsage('mails', 100);
        $subscription->recordFeatureUsage('mails', 100);
        $subscription->recordFeatureUsage('mails', 100);


        $this->assertEquals(300, $subscription->getUsedQuota('mails'));
        $this->assertEquals(300, $subscription->getTotalUsedQuota('mails'));

        $subscription->recordFeatureUsage('mails', 100);

        $this->assertEquals(300, $subscription->getUsedQuota('mails'));
        $this->assertEquals(400, $subscription->getTotalUsedQuota('mails'));
    }

    public function test_feature_usage_over_the_amount_with_metering()
    {
        $user = User::factory()->create();

        $plan = Saas::getPlan(static::$billingMonthlyPlanId);

        $subscription = $this->createSubscription($user, $plan);

        $overQuota = 'not_set';

        $subscription->recordFeatureUsage('metered.build.minutes', 4000, true, function ($feature, $valueOverQuota, $subscription) use (&$overQuota) {
            $overQuota = $valueOverQuota;
        });

        $this->assertEquals(1000, $overQuota);

        $this->assertEquals(
            3000,
            $subscription->getUsedQuota('metered.build.minutes')
        );

        $usage = $subscription->usageRecordsFor(static::$billingMeteredPriceId)[0]->total_usage;

        $this->assertEquals(1000, $usage);

        // The new feature record should use only the metered billing.
        $subscription->recordFeatureUsage('metered.build.minutes', 4000, true, function ($feature, $valueOverQuota, $subscription) use (&$overQuota) {
            $overQuota = $valueOverQuota;
        });

        $this->assertEquals(4000, $overQuota);

        $usage = $subscription->usageRecordsFor(static::$billingMeteredPriceId)[0]->total_usage;

        $this->assertEquals(5000, $usage);

        $this->assertEquals(
            3000,
            $subscription->getUsedQuota('metered.build.minutes')
        );
    }

    public function test_feature_usage_on_unlimited()
    {
        $user = User::factory()->create();

        $plan = Saas::getPlan(static::$billingMonthlyPlanId)
            ->features([
                Saas::feature('Seats', 'teams')->unlimited()->notResettable(),
            ]);

        $subscription = $this->createSubscription($user, $plan);

        $overQuota = 0;

        $subscription->recordFeatureUsage('teams', 100, true, function ($feature, $valueOverQuota, $subscription) use (&$overQuota) {
            $overQuota = 'set';
        });

        $this->assertEquals(
            100,
            $subscription->getUsedQuota('teams')
        );

        Carbon::setTestNow(now()->addMonths(1));

        $this->assertEquals(
            100,
            $subscription->getUsedQuota('teams')
        );

        $this->assertEquals(
            -1,
            $subscription->getRemainingQuota('teams')
        );

        $this->assertEquals(0, $overQuota);
    }

    public function test_downgrading_plan()
    {
        $user = User::factory()->create();

        $freePlan = Saas::getPlan(static::$billingFreePlanId);

        $paidPlan = Saas::getPlan(static::$billingMonthlyPlanId);

        $subscription = $this->createSubscription($user, $paidPlan);

        $subscription->recordFeatureUsage('teams', 10);

        $overQuotaFeatures = $subscription->featuresOverQuotaWhenSwapping(
            static::$billingFreePlanId
        );

        $this->assertCount(
            1,
            $overQuotaFeatures
        );

        $this->assertEquals(
            'teams',
            $overQuotaFeatures->first()->getId()
        );

        $subscription->swap((string) $freePlan);

        $this->assertTrue($subscription->featureOverQuota('teams'));
    }

    public function test_sync_manually_the_feature_values()
    {
        Saas::syncFeatureUsage('teams', function ($subscription, Feature $feature) {
            $this->assertInstanceOf(Subscription::class, $subscription);
            $this->assertInstanceOf(Feature::class, $feature);

            return 5;
        });

        $user = User::factory()->create();

        $plan = Saas::getPlan(static::$billingMonthlyPlanId)
            ->features([
                Saas::feature('Seats', 'teams', 100)->notResettable(),
            ]);

        $subscription = $this->createSubscription($user, $plan);

        $subscription->recordFeatureUsage('teams', 5);

        $this->assertEquals(10, $subscription->getUsedQuota('teams'));
    }
}
