<?php

namespace Octo\Billing\Models;

use Illuminate\Database\Eloquent\Model;
use Octo\Billing\Feature;
use Octo\Billing\Saas;

class Usage extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'subscription_usages';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'subscription_id',
        'feature_id',
        'used',
        'used_total',
    ];

    /**
     * Recalculate the usage values based on the user-defined callbacks.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $subscription
     * @param  \Octo\Billing\Feature  $feature
     * @return self
     */
    public function recalculate(Model $subscription, Feature $feature)
    {
        $usageValue = Saas::applyFeatureUsageSync($subscription, $feature);

        // If no callback was defined just return the same instance.
        if (is_null($usageValue)) {
            return $this;
        }

        return $this->fill([
            'used' => $usageValue,
            'used_total' => $usageValue,
        ]);
    }
}
