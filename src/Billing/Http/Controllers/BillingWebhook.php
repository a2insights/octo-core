<?php

namespace Octo\Billing\Http\Controllers;

use Laravel\Cashier\Http\Controllers\WebhookController;

class BillingWebhook extends WebhookController
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
                $subscription->resetQuotas();
            }

            if (@$data['lines']['data'][0]['plan']['id']) {
                $user->forceFill(['current_subscription_id' => $data['lines']['data'][0]['plan']['id']])->save();
            }
        }

        return $this->successMethod();
    }

    /**
       * Handle customer subscription updated.
       *
       * @param  array  $payload
       * @return \Symfony\Component\HttpFoundation\Response
       */
    protected function handleCustomerSubscriptionUpdated(array $payload)
    {
        parent::handleCustomerSubscriptionUpdated($payload);

        if ($user = $this->getUserByStripeId($payload['data']['object']['customer'])) {
            $data = $payload['data']['object'];

            $subscription = $user->subscriptions()
                ->whereStripeId($data['id'] ?? null)
                ->first();

            if (@$data['items']['data'][0]['plan']['id']) {
                $subscription->stripe_price = $data['items']['data'][0]['plan']['id'];
                $subscription->save();
            }

            if ($subscription) {
                if ($data['cancel_at']) {
                    $user->forceFill(['current_subscription_id' => null])->save();
                } else {
                    $user->forceFill(['current_subscription_id' => $subscription->stripe_price])->save();
                }
            }
        }

        return $this->successMethod();
    }
}
