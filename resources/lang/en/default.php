<?php

return [
    'user' => [
        'register' => [
            'accept_terms' => 'I accept the <a href=":terms_url" class="underline">Terms of Use</a> and <a href=":policies_url" class="underline">Policies</a>',
            'phone' => 'Phone',
        ],
        'profile' => [
            'phone' => [
                'title' => 'Phone',
                'description' => 'Add and update your phone number',
                'submit' => 'Update',
                'notify' => __('filament-breezy::default.profile.personal_info.notify'),
            ],
            'username' => [
                'title' => 'Username',
                'description' => 'Add and update your username',
                'submit' => 'Update',
                'notify' => __('filament-breezy::default.profile.personal_info.notify'),
            ],
        ],
    ],
];
