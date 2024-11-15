<?php

return [
    'users' => [
        'register' => [
            'accept_terms' => 'I accept the <a href=":terms_url" class="underline">Terms of Service</a> and <a href=":privacy_policy_url" class="underline">Privacy Policy</a>',
            'phone' => 'Phone',
        ],
        'profile' => [
            'phone' => [
                'title' => 'Phone',
                'description' => 'Add and update your phone number',
                'submit' => 'Update',
                'notify' => 'Profile updated successfully!',
            ],
            'username' => [
                'title' => 'Username',
                'description' => 'Add and update your username',
                'submit' => 'Update',
                'notify' => 'Password updated successfully!',
            ],
        ],
        'navigation' => [
            'user' => 'User|Users',
            'role' => 'Role|Roles',
            'group' => 'Users',
        ],
    ],

    'features' => [
        'title' => 'Features',
        'heading' => 'Features',
        'subheading' => 'Enable or disable features of the application.',
        'auth' => [
            'title' => 'Auth',
            'registration' => [
                'label' => 'Register',
                'help_text' => 'Enable register page.',
            ],
        ],
        'developer' => [
            'title' => 'Developer',
            'webhooks' => [
                'title' => 'Webhooks',
                'help_text' => 'Will anable webhooks page.',
                'history' => [
                    'label' => 'Webhooks History',
                    'help_text' => 'The events will be stored in the database.',
                ],
                'poll_interval' => [
                    'label' => 'Webhooks poll interval',
                    'help_text' => 'Time interval in seconds.',
                ],
                'models' => [
                    'label' => 'Webhooks models',
                    'help_text' => 'The models that be listed in the webhooks page.',
                ],
            ],
        ],
        'user' => [
            'title' => 'User',
            'switch_language' => [
                'label' => 'Switch Language',
                'help_text' => 'Enable switch language option in the top bar.',
            ],
            'phone' => [
                'label' => 'Phone',
                'help_text' => 'Enable phone in the register page and profile.',
            ],
            'username' => [
                'label' => 'Username',
                'help_text' => 'Enable username in the register page and profile.',
            ],
        ],
        'terms_and_privacy_policy' => [
            'title' => 'Terms and Privacy Policy',
            'help_text' => 'Enable terms and policies page.',
            'terms' => [
                'label' => 'Terms',
            ],
            'privacy_policy' => [
                'label' => 'Privacy Policy',
            ],
        ],
    ],

    'settings' => [
        'title' => 'Settings',
        'heading' => 'Settings',
        'subheading' => 'Configure the behavior of the application.',
        'seo' => [
            'title' => 'SEO',
            'name' => [
                'label' => 'Name',
            ],
            'keywords' => [
                'label' => 'Keywords',
                'help_text' => 'Enter to add keywords.',
            ],
            'description' => [
                'label' => 'Description',
                'help_text' => 'HTML not allowed.',
            ],
        ],
        'style' => [
            'title' => 'Style',
            'logo' => [
                'label' => 'Logo',
                'help_text' => 'Upload your logo. Recommended size: 3x1 ratio.',
            ],
            'logo_size' => [
                'label' => 'Logo Size',
                'help_text' => 'Example: 2rem',
            ],
            'favicon' => [
                'label' => 'Favicon',
            ],
        ],
        'security' => [
            'title' => 'Security',
            'restrict_ips' => [
                'label' => 'Restrict IPs',
                'help_text' => 'Caution: If you block your own IP address, you will be locked out of your sistema. And you will have to manually remove your IP address from the database or access from another IP address.',
            ],
            'restrict_users' => [
                'label' => 'Restrict Users',
                'help_text' => 'Caution: If you block your own user, you will be locked out of your sistema. And you will have to manually remove your user from the database or access from another user.',
            ],
        ],
        'localization' => [
            'title' => 'Localization',
            'timezone' => [
                'label' => 'Timezone',
                'help_text' => 'Current time is :time.',
            ],
            'locale' => [
                'label' => 'Locale',
                'help_text' => 'If you change the locale, the locale will be displayed according to the locale you set.',
            ],
            'locales' => [
                'label' => 'Locales',
                'help_text' => 'List of locales available.',
            ],
        ],
    ],

    'privacy-policy' => [
        'title' => 'Privacy Policy',
    ],

    'terms-of-service' => [
        'title' => 'Terms of Service',
    ],
];
