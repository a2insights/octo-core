<?php

namespace Octo\Settings;

use Spatie\LaravelSettings\Settings as BaseSettings;

class WebhooksSettings extends BaseSettings
{
    public array $models = [];

    public bool $history;

    public ?string $poll_interval;

    public static function group(): string
    {
        return 'webhooks_settings';
    }
}
