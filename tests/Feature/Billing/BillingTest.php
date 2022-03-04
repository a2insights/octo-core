<?php

namespace Octo\Tests\Feature\Billing;

use Octo\Tests\Feature\Billing\Models\User;

class BillingTest extends TestCase
{
    public function test_billing_redirect_to_portal()
    {
        $user = User::factory()->create();

        $user->subscriptions()->delete();

        $this->actingAs($user)
            ->get(route('billing.subscription.plan-subscribe', ['plan' => static::$billingFreePlanId]))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('billing.portal'))
            ->assertStatus(302);
    }
}
