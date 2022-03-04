<?php

namespace Octo\Tests\Feature\Billing;

use Octo\Tests\Feature\Billing\Models\User;

class InvoiceTest extends TestCase
{
    public function test_invoices_index()
    {
        $user = User::factory()->create();

        $user->subscriptions()->delete();

        $this->actingAs($user)
            ->get(route('billing.subscription.plan-subscribe', ['plan' => static::$billingFreePlanId]))
            ->assertOk();

        $user->newSubscription('main', static::$billingPlanId)->create('pm_card_visa');

        $invoices = $user->invoicesIncludingPending()->map(function ($invoice) {
            return [
                'description' => $invoice->lines->data[0]->description,
                'created' => $invoice->created,
                'paid' => $invoice->paid,
                'status' => $invoice->status,
                'url' => $invoice->hosted_invoice_url ?: null,
            ];
        });

        $this->actingAs($user)
            ->get(route('billing.invoice.index'))
            ->assertSee($invoices[0]['description']);
    }
}
