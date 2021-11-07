<?php
return [

    'network' => [
        'facebook' => '#',
        'instagram' => '#',
        'youtube' => '#',
    ],

    'footer' => [
        'tagline' => "Copyright © " . date('Y') . " " . config('app.name')
    ],

    'plugins' => [
        'subscribe' => [
            'headline' => 'Something new is coming!',
            'tagline' => 'This application is on for testers. But you can test too. If you want to receive updates join our newsletter.'
        ]
    ],

    'features' => [
        // \Octo\Features::notifications(['pusher' => false, 'pusher-queued' => false]),
        // \Octo\Features::billingDasboard(),
        // \Octo\Features::welcomeUserNotifications(['queued' => false, 'sms' => false]),
        // \Octo\Features::phoneUser(),
        // \Octo\Features::sms(['provider' => 'nexmo'])
    ],
];
