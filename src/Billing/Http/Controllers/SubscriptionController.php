<?php

namespace Octo\Billing\Http\Controllers;

use Illuminate\Routing\Controller;
use Octo\Billing\Billing;
use Octo\Billing\Contracts\HandleSubscriptions;
use Octo\Billing\Saas;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('octo::billing.subscription.index');
    }

    /**
     * Redirect the user to subscribe to the plan.
     *
     * @param  \Octo\Billing\Contracts\HandleSubscriptions  $manager
     * @param  string  $planId
     * @return \Illuminate\Http\Response
     */
    public function redirectWithSubscribeIntent(HandleSubscriptions $manager, string $planId)
    {
        $billable = Billing::getBillable();

        $plan = Saas::getPlan($planId);

        $subscription = $billable->newSubscription($plan->getName(), $plan->getId());

        $checkout = $manager->checkoutOnSubscription(
            $subscription,
            $billable,
            $plan,
        );

        return view('octo::billing.checkout', [
            'checkout' => $checkout,
            'stripeKey' => config('cashier.key'),
        ]);
    }

    /**
     * Get the current billable subscription.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $billable
     * @param  string  $subscription
     * @return \Laravel\Cashier\Subscription|null
     */
    protected function getCurrentSubscription($billable, string $subscription)
    {
        return $billable->subscription($subscription);
    }
}
