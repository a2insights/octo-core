<?php

$providers = require __DIR__ . '/../config/sms-providers.php';

return collect($providers)->mapWithKeys(function ($provider) {
    return [$provider['config-key'] => $provider['config']];
})->toArray();
