<?php

namespace Octo\Tests\Feature\Billing;

use Octo\Billing\Saas;
use Octo\Tests\Feature\Billing\Models\User;

class SubscriptionTest extends TestCase
{
    public function test_index_subscriptions()
    {
        $user = User::factory()->create();
        $plan = Saas::getPlan(static::$billingFreePlanId);
        $subscription = $this->createStripeSubscription($user, $plan);

        $this->actingAs($user)
            ->get(route('billing.subscription.index'))
            ->assertOk()
            ->assertSee($subscription->getPlan()->getName());
    }

    public function test_subscribe_to_free_plan()
    {
        $user = User::factory()->create();

        $user->subscriptions()->delete();

        $this->actingAs($user)
            ->get(route('billing.subscription.plan-subscribe', ['plan' => static::$billingFreePlanId]))
            ->assertOk();

        $user->newSubscription('main', static::$billingFreePlanId)->create('pm_card_us');

        $this->assertCount(1, $user->subscriptions);
    }

    public function test_subscribe_to_paid_plan_without_payment_method()
    {
        $user = User::factory()->create();

        $user->subscriptions()->delete();

        $this->actingAs($user)
            ->get(route('billing.subscription.plan-subscribe', ['plan' => static::$billingPlanId]))
            ->assertOk();

        $this->assertCount(0, $user->subscriptions);
    }

    public function test_swap_to_paid_plan_without_payment_method()
    {
        $user = User::factory()->create();

        $user->subscriptions()->delete();

        $this->actingAs($user)
            ->get(route('billing.subscription.plan-subscribe', ['plan' => static::$billingFreePlanId]))
            ->assertOk();

        $user->newSubscription('main', static::$billingFreePlanId)->create('pm_card_us');

        $user->deletePaymentMethods();
    }

    public function test_cancel_and_resume_plan()
    {
        $user = User::factory()->create();

        $user->subscriptions()->delete();

        $this->actingAs($user)
            ->get(route('billing.subscription.plan-subscribe', ['plan' => static::$billingFreePlanId]))
            ->assertOk();

        $user->newSubscription('main', static::$billingFreePlanId)->create('pm_card_us');
    }
}
