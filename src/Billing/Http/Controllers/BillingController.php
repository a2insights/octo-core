<?php

namespace Octo\Billing\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Octo\Billing\Billing;

class BillingController extends Controller
{
    /**
     * Redirect the user to the subscriptions page.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return Redirect::route('billing.subscription.index');
    }

    /**
     * Redirect to the Stripe portal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function portal(Request $request)
    {
        return $this->getBillingPortalRedirect(
            Billing::getBillable($request)
        );
    }

    /**
     * Get the billing portal redirect response.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $billable
     * @return Illuminate\Routing\Redirector|\Illuminate\Http\Response
     */
    protected function getBillingPortalRedirect($billable)
    {
        $billable->createOrGetStripeCustomer();

        return Redirect::to($billable->billingPortalUrl(route('billing.dashboard')));
    }
}
