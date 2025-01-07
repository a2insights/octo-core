<?php

return [
    'users' => [
        'model' => A2Insights\FilamentSaas\User\User::class,
        'resource' => A2Insights\FilamentSaas\User\Filament\UserResource::class,
        'tenant_scope' => false,
    ],

    'companies' => [
        'model' => A2Insights\FilamentSaas\Tenant\Company::class,
    ],

    'terms_of_service_url' => 'terms-of-service',
    'privacy_url' => 'privacy-policy',
];
