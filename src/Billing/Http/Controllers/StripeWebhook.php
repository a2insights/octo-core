<?php

namespace Octo\Billing\Http\Controllers;

use Laravel\Cashier\Http\Controllers\WebhookController;

class StripeWebhook extends WebhookController
{
    /**
     * Handle invoice payment succeeded.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleInvoicePaymentSucceeded($payload)
    {
        if ($user = $this->getUserByStripeId($payload['data']['object']['customer'])) {
            $data = $payload['data']['object'];

            $subscription = $user->subscriptions()
                ->whereStripeId($data['subscription'] ?? null)
                ->first();

            if ($subscription) {
                $user->forceFill(['current_plan_id' => $subscription->stripe_price])->save();

                $subscription->resetQuotas();
            }
        }

        return $this->successMethod();
    }
}
