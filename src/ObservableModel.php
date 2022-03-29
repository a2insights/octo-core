<?php

namespace Octo;

use Illuminate\Support\Facades\Auth;
use Octo\Marketing\Stats\ContactStats;
use Octo\Marketing\Stats\CampaignStats;
use Illuminate\Support\Str;

trait ObservableModel
{
    protected static $stats = [
        'contact' => ContactStats::class,
        'campaign' => CampaignStats::class,
    ];

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

            $className = (new \ReflectionClass(self::class))->getShortName();

            $stats = @self::$stats[Str::lower($className)] ?? null;

            if (class_exists($stats)) {
                $stats::increase();
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

            $className = (new \ReflectionClass(self::class))->getShortName();

            $stats = @self::$stats[Str::lower($className)] ?? null;

            if (class_exists($stats)) {
                $stats::decrease();
            }
        });
    }
}
