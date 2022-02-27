<?php

namespace Octo\Billing\Http\Livewire;

use Exception;
use Illuminate\Http\Request;
use Laravel\Jetstream\InteractsWithBanner;
use Livewire\Component;
use Octo\Billing\Billing;

class ListPaymentMethods extends Component
{
    use InteractsWithBanner;

    /**
     * Render the compoenent.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function render(Request $request)
    {
        $billable = Billing::getBillable($request);

        $billable->updateDefaultPaymentMethodFromStripe();

        $defaultPaymentMethod = $billable->defaultPaymentMethod();

        $methods = $billable->paymentMethods()->filter(function ($method) {
            return $method->type === 'card';
        })->map(function ($method) use ($defaultPaymentMethod) {
            return (object) [
                'default' => $method->id === optional($defaultPaymentMethod)->id,
                'id' => $method->id,
                'brand' => $method->card->brand,
                'last_four' => $method->card->last4,
                'month' => $method->card->exp_month,
                'year' => $method->card->exp_year,
            ];
        });

        return view('octo::livewire.billing.payment-method.list-payment-methods', ['methods' => $methods]);
    }

    /**
     * Set the default payment method.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $paymentMethod
     * @return void
     */
    public function setAsDefault(Request $request, string $paymentMethod)
    {
        try {
            Billing::getBillable($request)->updateDefaultPaymentMethod($paymentMethod);
        } catch (Exception $e) {
            $this->dangerBanner(__('The default payment method got updated!'));
        }

        $this->banner('The default payment method got updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $paymentMethod
     * @return void
     */
    public function deletePaymentMethod(Request $request, string $paymentMethod)
    {
        try {
            $paymentMethod = Billing::getBillable($request)->findPaymentMethod($paymentMethod);
        } catch (Exception $e) {
            $this->banner('The payment method got removed!');

            return false;
        }

        if ($paymentMethod) {
            $paymentMethod->delete();
        }

        $this->banner('The payment method got removed!');
    }
}
