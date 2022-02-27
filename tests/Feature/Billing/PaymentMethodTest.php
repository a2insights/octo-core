<?php

namespace Octo\Tests\Feature\Billing;

use Octo\Tests\Feature\Billing\Models\User;

class PaymentMethodTest extends TestCase
{
    public function test_payment_methods_index()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('billing-portal.payment-method.index'))
            ->assertOk();

        $user->createOrGetStripeCustomer();

        $user->addPaymentMethod('pm_card_visa');
        $user->addPaymentMethod('pm_card_mastercard');

        $defaultPaymentMethod = $user->defaultPaymentMethod();

        $methods = $user->paymentMethods()
            ->filter(function ($method) {
                return $method->type === 'card';
            })->map(function ($method) use ($defaultPaymentMethod) {
                return [
                    'default' => $method->id === optional($defaultPaymentMethod)->id,
                    'id' => $method->id,
                    'brand' => $method->card->brand,
                    'last_four' => $method->card->last4,
                    'month' => $method->card->exp_month,
                    'year' => $method->card->exp_year,
                ];
            });

        $this->actingAs($user)
            ->get(route('billing-portal.payment-method.index'))
            ->assertSee($methods[0]['brand']);
    }
}
