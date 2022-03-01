<?php

namespace Octo\Billing\Models;

use Laravel\Cashier\Subscription as CashierSubscription;
use Octo\Billing\Concerns\HasPlans;
use Octo\Billing\Concerns\HasQuotas;

class Subscription extends CashierSubscription
{
    use HasPlans;
    use HasQuotas;

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
