<?php

namespace Octo\Tests\Feature\Billing;

use Octo\Tests\Feature\Billing\Models\User;

class BillingPortalTest extends TestCase
{
    public function test_billing_redirect_to_portal()
    {
        $user = User::factory()->create();

        $user->subscriptions()->delete();

        $this->actingAs($user)
            ->get(route('billing-portal.subscription.plan-subscribe', ['plan' => static::$stripeFreePlanId]))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('billing-portal.portal'))
            ->assertStatus(302);
    }
}
