<?php

namespace Octo\Concerns;

trait HasSmsProviderConfig
{
    private function getSmsProvider($provider, $field = 'slug')
    {
        $providerInfos = require __DIR__ . '/../../config/sms-providers.php';

        return collect($providerInfos)->where($field, $provider)->whereNotNull('enable')->first();
    }
}
