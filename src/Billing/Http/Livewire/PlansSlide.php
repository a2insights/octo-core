<?php

namespace Octo\Billing\Http\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\InteractsWithBanner;
use Livewire\Component;
use Octo\Billing\Billing;
use Octo\Billing\Contracts\HandleSubscriptions;
use Octo\Billing\Saas;

class PlansSlide extends Component
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

        return view('octo::livewire.billing.subscription.plans-slide', [
            'hasDefaultPaymentMethod' => $billable->hasDefaultPaymentMethod(),
            'paymentMethods' => $billable->paymentMethods(),
            'plans' => Saas::getPlans(),
            'subscriptions' => $billable->subscriptions,
            'currentPlan' => $billable->current_plan_id ? Saas::getPlan($billable->current_plan_id) : null,
            'billable' => $billable,
        ]);
    }

    /**
     * Redirect the user to subscribe to the plan.
     *
     * @param  string  $planId
     * @return \Illuminate\Http\Response
     */
    public function subscribeToPlan(string $planId)
    {
        $plan = Saas::getPlan($planId);
        $billable = Billing::getBillable();

        if ($plan->getPrice() === 0.0) {
            $billable->forceFill([ 'current_plan_id' => $plan->getId()])->save();
            $this->banner("The plan {$plan->getName()} is now active!");
            return;
        }

        return redirect()->route('billing.subscription.plan-subscribe', ['plan' => $planId]);
    }

    /**
     * Swap the plan to a new one.
     *
     * @param  \Octo\Billing\Contracts\HandleSubscriptions  $manager
     * @param  string  $planId
     * @return \Illuminate\Http\Response|void
     */
    public function swapPlan(HandleSubscriptions $manager, string $planId)
    {
        $plan = Saas::getPlan($planId);
        $billable = Billing::getBillable();

        if ($plan->getPrice() === 0.0) {
            $billable->forceFill([ 'current_plan_id' => $plan->getId()])->save();

            $this->banner("The plan got successfully changed to {$plan->getName()}!");

            return;
        }

        if (! $subscription = $this->getCurrentSubscription($billable, $plan->getName())) {
            $this->dangerBanner("The subscription {$plan->getName()} does not exist.");

            return false;
        }

        // Otherwise, check if it is not already subscribed to the new plan and initiate
        // a plan swapping. It also takes proration into account.
        if ($billable->subscribed($subscription->name, $plan->getId())) {
            $hasValidSubscription = $subscription && $subscription->valid();

            $subscription = value(function () use ($hasValidSubscription, $subscription, $plan, $billable, $manager) {
                if ($hasValidSubscription) {
                    return $manager->swapToPlan($subscription, $billable, $plan);
                }

                // However, this is the only place where a ->create() method is involved. At this point, the user has
                // a default payment method set and we will initialize the subscription in case it is not subscribed
                // to a plan with the given subscription name.
                return $manager->subscribeToPlan(
                    $billable,
                    $plan,
                );
            });
        }

        $this->banner("The plan got successfully changed to {$plan->getName()}!");
    }

    /**
     * Cancel the current active subscription.
     *
     * @param  \Octo\Billing\Contracts\HandleSubscriptions  $manager
     * @return void
     */
    public function cancelSubscription(HandleSubscriptions $manager, string $planId)
    {
        $billable = Billing::getBillable();
        $plan = Saas::getPlan($planId);

        if ($billable->current_plan_id === $plan->getId()) {
            $billable->forceFill([ 'current_plan_id' => null])->save();
        }


        if ($plan->getPrice() === 0.0) {
            $this->banner('The current subscription got cancelled!');

            return false;
        }

        if (! $subscription = $this->getCurrentSubscription($billable, $plan->getName())) {
            $this->dangerBanner("The subscription {$plan->getName()} does not exist.");

            return false;
        }

        $manager->cancelSubscription($subscription, $billable);

        $this->banner('The current subscription got cancelled!');
    }

    /**
     * Resume the current cancelled subscription.
     *
     * @param  \Octo\Billing\Contracts\HandleSubscriptions  $manager
     * @return \Illuminate\Http\Response|void
     */
    public function resumeSubscription(HandleSubscriptions $manager, string $planId)
    {
        $billable = Billing::getBillable();
        $plan = Saas::getPlan($planId);

        if (! $subscription = $this->getCurrentSubscription($billable, $plan->getName())) {
            $this->dangerBanner("The subscription {$plan->getName()} does not exist.");

            return false;
        }

        $manager->resumeSubscription($subscription, $billable);

        $this->banner('The subscription has been resumed.');
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
