<?php

return [
    'admin_path' => 'admin',
    'tenant_path' => 'company',

    'users' => [
        'model' => A2insights\FilamentSaas\User\User::class,
        'resource' => A2insights\FilamentSaas\User\Filament\UserResource::class,
        'tenant_scope' => false,
    ],

    'companies' => [
        'model' => A2insights\FilamentSaas\Tenant\Company::class,
    ],
];
