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

    'features' => [
        // \Octo\Features::notifications(['pusher' => false, 'pusher-queued' => false]),
        // \Octo\Features::billingDasboard(),
        // \Octo\Features::welcomeUserNotifications(['queued' => false, 'sms' => false]),
        // \Octo\Features::phoneUser(),
        // \Octo\Features::sms(['provider' => 'nexmo'])
    ],
];
