<?php

namespace Octo\Billing\Http\Livewire;

use Laravel\Jetstream\InteractsWithBanner;
use Livewire\Component;
use Octo\Billing\Billing;
use Octo\Billing\Contracts\HandleSubscriptions;
use Octo\Billing\Saas;

class PlansSlide extends Component
{
    use InteractsWithBanner;

    private $user;

    /**
     * Sleep for a second to wait for stripe updates
     *
     * @return void
     */
    public function sleep()
    {
        sleep(4);
    }

    /**
     * Render the compoenent.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        $this->user = Billing::getBillable();

        return view('octo::billing.subscription.plans-slide', [
            'hasDefaultPaymentMethod' => $this->user->hasDefaultPaymentMethod(),
            'paymentMethods' => $this->user->paymentMethods(),
            'plans' => Saas::getPlans(),
            'subscriptions' => $this->user->subscriptions,
            'currentPlan' => $this->user->current_subscription_id ? Saas::getPlan($this->user->current_subscription_id) : null,
            'billable' => $this->user,
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
        return $this->redirectRoute('billing.subscription.plan-subscribe', ['plan' => $planId]);
    }

    /**
     * Swap the plan to a new one.
     *
     * @param  \Octo\Billing\Contracts\HandleSubscriptions  $manager
     * @param  string  $planId
     * @return \Illuminate\Http\Response|bool
     */
    public function swapPlan(HandleSubscriptions $manager, string $planId)
    {
        $this->user = Billing::getBillable();
        $plan = Saas::getPlan($planId);

        if (! $subscription = $this->getCurrentSubscription($this->user, $plan->getName())) {
            $this->dangerBanner("The subscription {$plan->getName()} does not exist.");

            return false;
        }

        // Otherwise, check if it is not already subscribed to the new plan and initiate
        // a plan swapping. It also takes proration into account.
        if ($this->user->subscribed($subscription->name, $plan->getId())) {
            $hasValidSubscription = $subscription && $subscription->valid();

            $subscription = value(function () use ($hasValidSubscription, $subscription, $plan, $manager) {
                if ($hasValidSubscription) {
                    return $manager->swapToPlan($subscription, $this->user, $plan);
                }

                // However, this is the only place where a ->create() method is involved. At this point, the user has
                // a default payment method set and we will initialize the subscription in case it is not subscribed
                // to a plan with the given subscription name.
                return $manager->subscribeToPlan(
                    $this->user,
                    $plan,
                );
            });
        }

        $this->sleep();

        return $this->redirectRoute('billing.subscription.index');
    }

    /**
     * Cancel the current active subscription.
     *
     * @param  \Octo\Billing\Contracts\HandleSubscriptions  $manager
     * @return void
     */
    public function cancelSubscription(HandleSubscriptions $manager, string $planId)
    {
        $this->user = Billing::getBillable();
        $plan = Saas::getPlan($planId);

        if (! $subscription = $this->getCurrentSubscription($this->user, $plan->getName())) {
            $this->dangerBanner("The subscription {$plan->getName()} does not exist.");

            return false;
        }

        $manager->cancelSubscription($subscription, $this->user);

        $this->sleep();

        return $this->redirectRoute('billing.subscription.index');
    }

    /**
     * Resume the current canceled subscription.
     *
     * @param  \Octo\Billing\Contracts\HandleSubscriptions  $manager
     * @return \Illuminate\Http\Response|void
     */
    public function resumeSubscription(HandleSubscriptions $manager, string $planId)
    {
        $this->user = Billing::getBillable();
        $plan = Saas::getPlan($planId);

        if (! $subscription = $this->getCurrentSubscription($this->user, $plan->getName())) {
            $this->dangerBanner("The subscription {$plan->getName()} does not exist.");

            return false;
        }

        $manager->resumeSubscription($subscription, $this->user);

        $this->sleep();

        return $this->redirectRoute('billing.subscription.index');
    }

    /**
     * Get the current billable subscription.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $this->user
     * @param  string  $subscription
     * @return \Laravel\Cashier\Subscription|null
     */
    protected function getCurrentSubscription($user, string $subscription)
    {
        return $user->subscription($subscription);
    }
}
