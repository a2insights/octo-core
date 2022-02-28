<?php

namespace Octo\Billing\Contracts;

use Illuminate\Http\Request;
use Octo\Billing\Plan;

interface HandleSubscriptions
{
    /**
     * Mutate the checkout object before redirecting the user to subscribe to a certain plan.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $billable
     * @param  \Octo\Billing\Plan  $plan
     * @return mixed
     */
    public function checkoutOnSubscription($subscription, $billable, Plan $plan);

    /**
     * Subscribe the user to a given plan.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $billable
     * @param  \Octo\Billing\Plan  $plan
     * @return void
     */
    public function subscribeToPlan($billable, Plan $plan);

    /**
     * Swap the current subscription plan.
     *
     * @param  \Octo\Billing\Models\Stripe\Subscription  $subscription
     * @param  \Illuminate\Database\Eloquent\Model  $billable
     * @param  \Octo\Billing\Plan  $plan
     * @return \Octo\Billing\Models\Stripe\Subscription
     */
    public function swapToPlan($subscription, $billable, Plan $plan);

    /**
     * Define the logic to be called when the user requests resuming a subscription.
     *
     * @param  \Octo\Billing\Models\Stripe\Subscription  $subscription
     * @param  \Illuminate\Database\Eloquent\Model  $billable
     * @return void
     */
    public function resumeSubscription($subscription, $billable);

    /**
     * Define the subscriptioncancellation action.
     *
     * @param  \Octo\Billing\Models\Stripe\Subscription  $subscription
     * @param  \Illuminate\Database\Eloquent\Model  $billable
     * @return void
     */
    public function cancelSubscription($subscription, $billable);
}
