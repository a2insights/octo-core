<?php

namespace Octo\Billing\Concerns;

use Octo\Billing\Saas;

trait HasPlans
{
    /**
     * Get the plan this instance belongs to.
     *
     * @return \Octo\Billing\Plan
     */
    public function getPlan()
    {
        return Saas::getPlan($this->getPlanIdentifier());
    }

    /**
     * Get the service plan identifier for the resource.
     *
     * @return void
     */
    public function getPlanIdentifier()
    {
        return $this->stripe_price;
    }
}
