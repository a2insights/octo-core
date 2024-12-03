<?php

namespace A2Insights\FilamentSaas\Webhook\Filament\Pages;

use A2Insights\FilamentSaas\Features\Features;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Marjose123\FilamentWebhookServer\Pages\Webhooks as Marjose123Webhooks;

class Webhooks extends Marjose123Webhooks
{
    use HasPageShield;

    public static function getNavigationGroup(): ?string
    {
        return 'System';
    }

    public static function canAccess(): bool
    {
        $features = Cache::remember('filament-saas.features', now()->addHours(10), fn () => App::make(Features::class));

        return $features->webhooks;
    }
}
