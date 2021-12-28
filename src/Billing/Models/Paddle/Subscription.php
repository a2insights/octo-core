<?php

namespace Octo\Billing\Models\Paddle;

use Laravel\Paddle\Subscription as CashierSubscription;
use Octo\Billing\Concerns\HasPlans;
use Octo\Billing\Concerns\HasQuotas;

class Subscription extends CashierSubscription
{
    use HasPlans;
    use HasQuotas;

    /**
     * Get the service plan identifier for the resource.
     *
     * @return mixed
     */
    public function getPlanIdentifier()
    {
        return $this->paddle_plan;
    }
}
