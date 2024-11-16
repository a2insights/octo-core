<?php

namespace A2Insights\FilamentSaas\Settings;

use Spatie\LaravelSettings\Settings as BaseSettings;

class WhatsappChatSettings extends BaseSettings
{
    public array $attendants = [];

    public ?string $header;

    public ?string $footer;

    public static function group(): string
    {
        return 'whatsapp_chat_settings';
    }
}
