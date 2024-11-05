<?php

namespace A2insights\FilamentSaas\Webhook\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Marjose123\FilamentWebhookServer\Pages\Webhooks as Marjose123Webhooks;

class Webhooks extends Marjose123Webhooks
{
    use HasPageShield;

    public static function getNavigationGroup(): ?string
    {
        return 'System';
    }
}
