<?php

namespace Octo;

use Illuminate\Support\Facades\Auth;

trait ObservableModel
{
    protected static function booted()
    {
        parent::booted();

        static::creating(function ($model) {
            $user = Auth::user();


            $subscription = $user?->currentSubscription;

            if (!$subscription) {
                return;
            }

            $features = $subscription->features;

            /** @var \Octo\Billing\Feature $featureObservable */
            $featureObservable = $features->filter(fn ($f) => $f->getModel() === self::class)->first();

            if ($featureObservable) {
                if ($subscription->getRemainingQuota($featureObservable) <= 0) {
                    abort(403, 'Subscription quota exceeded');
                }
            }
        });


        static::created(function ($model) {
            $user = Auth::user();

            $subscription = $user?->currentSubscription;

            if (!$subscription) {
                return;
            }

            $features = $subscription->features;

            /** @var \Octo\Billing\Feature $featureObservable */
            $featureObservable = $features->filter(fn ($f) => $f->getModel() === self::class)->first();

            if ($featureObservable) {
                $subscription->recordFeatureUsage($featureObservable->getId(), $featureObservable->calculeUsage($model));
            }
        });

        static::deleted(function ($model) {
            $user = Auth::user();

            $subscription = $user?->currentSubscription;

            if (!$subscription) {
                return;
            }

            $features = $subscription->features;

            /** @var \Octo\Billing\Feature $featureObservable */
            $featureObservable = $features->filter(fn ($f) => $f->getModel() === self::class)->first();

            if ($featureObservable) {
                $subscription->reduceFeatureUsage($featureObservable->getId(), $featureObservable->calculeUsage($model));
            }
        });
    }
}
