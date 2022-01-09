<?php

namespace Octo\Billing\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Octo\Billing\BillingPortal;
use Octo\Billing\Contracts\HandleSubscriptions;
use Octo\Billing\Saas;

class SubscriptionController extends Controller
{
    /**
     * Initialize the controller.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $request->merge([
            'subscription' => $request->subscription ?: 'main',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('octo::livewire.billing-portal.subscription.index');
    }

    /**
     * Redirect the user to subscribe to the plan.
     *
     * @param  \Octo\Billing\Contracts\HandleSubscriptions  $manager
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $planId
     * @return \Illuminate\Http\Response
     */
    public function redirectWithSubscribeIntent(HandleSubscriptions $manager, Request $request, string $planId)
    {
        $billable = BillingPortal::getBillable($request);

        $plan = Saas::getPlan($planId);

        $subscription = $billable->newSubscription($request->subscription, $plan->getId());

        $checkout = $manager->checkoutOnSubscription(
            $subscription, $billable, $plan, $request
        );

        return view('octo::blade.billing-checkout', [
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
