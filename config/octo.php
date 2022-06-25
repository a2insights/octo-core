<?php

return [
    'features' => [
        'billing' => env('BILLING_FEATURE', false),
    ],
    'free-plan-price-id' => env('FREE_PLAN_PRICE_ID', null),
];
