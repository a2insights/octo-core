<?php

namespace Octo\Billing\Http\Controllers;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use OctoBilling\OctoBilling;

class PaymentMethodController extends Controller
{
    /**
     * Initialize the controller.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware(function (Request $request, Closure $next) {
            OctoBilling::getBillable($request)->createOrGetStripeCustomer();

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('octo::billing.payment-method.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('octo::billing.payment-method.create', [
            'intent' => OctoBilling::getBillable($request)->createSetupIntent(),
            'stripe_key' => config('cashier.key'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'token' => ['required', 'string'],
        ]);

        $billable = OctoBilling::getBillable($request);

        $billable->addPaymentMethod($request->token);

        if (! $billable->hasDefaultPaymentMethod()) {
            $billable->updateDefaultPaymentMethod($request->token);
        }

        return Redirect::route('billing.payment-method.index')
            ->with('flash.banner', 'The new payment method got added!');
    }
}
