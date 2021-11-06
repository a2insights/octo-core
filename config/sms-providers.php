<?php

return [
    [
        "slug" => "touch-sms",
        "name" => "TouchSMS",
        "config-key" => "touchsms",
        "channel" => "NotificationChannels\TouchSms\TouchSmsChannel",
        "enable" => false,
        "sdk" => [
            'laravel-notification-channels/touch-sms'
        ],
        "env" => [
            'TOUCHSMS_TOKEN_ID',
            'TOUCHSMS_ACCESS_TOKEN',
            'TOUCHSMS_DEFAULT_SENDER'
        ],
        "config" => [
            'token_id' => env('TOUCHSMS_TOKEN_ID'),
            'access_token' => env('TOUCHSMS_ACCESS_TOKEN'),
            'default_sender' => env('TOUCHSMS_DEFAULT_SENDER', null),
        ]
    ],
    [
        "slug" => "clickatell",
        "name" => "Clickatell",
        "config-key" => "clickatell",
        "channel" => "NotificationChannels\Clickatell\ClickatellChannel",
        "enable" => false,
        "sdk" => [
            'laravel-notification-channels/clickatell'
        ],
        "env" => [
            'CLICKATELL_USER',
            'CLICKATELL_PASS',
            'CLICKATELL_API_ID'
        ],
        "config" => [
            'user'  => env('CLICKATELL_USER'),
            'pass' => env('CLICKATELL_PASS'),
            'api_id' => env('CLICKATELL_API_ID'),
        ]
    ],
    [
        "slug" => "jusibe",
        "name" => "Jusibe",
        "config-key" => "jusibe",
        "channel" => "NotificationChannels\Jusibe\JusibeChannel",
        "enable" => false,
        "sdk" => [
            'laravel-notification-channels/jusibe'
        ],
        "env" => [
            'JUSIBE_PUBLIC_KEY',
            'JUSIBE_ACCESS_TOKEN',
            'PROSPER'
        ],
        "config" => [
            'key' => env('JUSIBE_PUBLIC_KEY'),
            'token' => env('JUSIBE_ACCESS_TOKEN'),
            'sms_from' => 'PROSPER'
        ]
    ],
    [
        "slug" => "messagebird",
        "name" => "Messagebird",
        "config-key" => "messagebird",
        "channel" => "NotificationChannels\Messagebird\MessagebirdChannel",
        "enable" => false,
        "sdk" => [
            'laravel-notification-channels/messagebird'
        ],
        "env" => [
            'MESSAGEBIRD_ACCESS_KEY',
            'MESSAGEBIRD_ORIGINATOR',
            'MESSAGEBIRD_RECIPIENTS'
        ],
        "config" => [
            'access_key' => env('MESSAGEBIRD_ACCESS_KEY'),
            'originator' => env('MESSAGEBIRD_ORIGINATOR'),
            'recipients' => env('MESSAGEBIRD_RECIPIENTS'),
        ]
    ],
    [
        "slug" => "plivo",
        "name" => "Plivo",
        "config-key" => "plivo",
        "channel" => "NotificationChannels\Plivo\PlivoChannel",
        "enable" => false,
        "sdk" => [
            'laravel-notification-channels/plivo'
        ],
        "env" => [
            'PLIVO_AUTH_ID',
            'PLIVO_AUTH_TOKEN',
            'PLIVO_FROM_NUMBER'
        ],
        "config" => [
            'auth_id' => env('PLIVO_AUTH_ID'),
            'auth_token' => env('PLIVO_AUTH_TOKEN'),
            'from_number' => env('PLIVO_FROM_NUMBER'),
        ]
    ],
    [
        "slug" => "smsc-ru",
        "config-key" => "smscru",
        "name" => "Smsc.ru",
        "channel" => "NotificationChannels\SmscRu\SmscRuChannel",
        "enable" => false,
        "sdk" => [
            'laravel-notification-channels/smsc-ru'
        ],
        "env" => [
            'SMSCRU_LOGIN',
            'SMSCRU_SECRET',
            'SMSCRU_HOST'
        ],
        "config" => [
            'login'  => env('SMSCRU_LOGIN'),
            'secret' => env('SMSCRU_SECRET'),
            'host' => env('SMSCRU_HOST'),
            'sender' => 'John_Doe',
            'extra'  => [
                // any other API parameters
                // 'tinyurl' => 1
            ],

        ]
    ],
    [
        "slug" => "twilio",
        "name" => "Twilio",
        "config-key" => "twilio",
        "enable" => true,
        "channel" => "NotificationChannels\Twilio\TwilioChannel",
        "sdk" => [
            'laravel-notification-channels/twilio'
        ],
        "env" => [
            'TWILIO_USERNAME',
            'TWILIO_PASSWORD',
            'TWILIO_AUTH_TOKEN',
            'TWILIO_ACCOUNT_SID',
            'TWILIO_FROM',
            'TWILIO_ALPHA_SENDER',
            'TWILIO_DEBUG_TO',
            'TWILIO_SMS_SERVICE_SID'
        ],
        "config" => []
    ],
    [
        "slug" => "authy",
        "name" => "Authy",
        "config-key" => "authy",
        "enable" => false,
        "channel" => "NotificationChannels\Authy\AuthyChannel",
        "sdk" => [
            'laravel-notification-channels/authy'
        ],
        "env" => [
            'AUTHY_SECRET'
        ],
        "config" => [
            'secret' => env('AUTHY_SECRET')
        ]
    ],
    [
        "slug" => "cmsms",
        "name" => "CMSMS",
        "config-key" => "cmsms",
        "enable" => false,
        "channel" => "NotificationChannels\Cmsms\CmsmsChannel",
        "sdk" => [
            'laravel-notification-channels/cmsms'
        ],
        "env" => [
            'CMSMS_PRODUCT_TOKEN',
            'CMSMS_ORIGINATOR',
        ],
        "config" => [
            'product_token' => env('CMSMS_PRODUCT_TOKEN'),
            'originator' => env('CMSMS_ORIGINATOR'),
        ]
    ],
    [
        "slug" => "46elks",
        "name" => "46Elks",
        "config-key" => "46elks",
        "enable" => false,
        "channel" => "NotificationChannels\Elks\FortySixElksChannel",
        "sdk" => [
            'laravel-notification-channels/46elks'
        ],
        "env" => [
            'FORTY_SIX_ELKS_USERNAME',
            'FORTY_SIX_ELKS_PASSWORD',
        ],
        "config" => [
            'username' => env('FORTY_SIX_ELKS_USERNAME'),
            'password' => env('FORTY_SIX_ELKS_PASSWORD'),
        ]
    ],
    [
        "slug" => "sipgate",
        "name" => "Sipgate",
        "config-key" => "sipgate",
        "enable" => false,
        "channel" => "sipgate",
        "sdk" => [
            'laravel-notification-channels/46elks'
        ],
        "env" => [
            'SIPGATE_USERNAME',
            'SIPGATE_PASSWORD',
            'SIPGATE_SMSID',
            'SIPGATE_NOTIFICATIONS_ENABLED',
        ],
        "config" => [
            'username' => env('SIPGATE_USERNAME'),
            'password' => env('SIPGATE_PASSWORD'),
            'smsId' => env('SIPGATE_SMSID'),
            'enabled' => env('SIPGATE_NOTIFICATIONS_ENABLED', true),
        ]
    ],
    [
        "slug" => "all-my-sms",
        "name" => "AllMySms",
        "config-key" => "all_my_sms",
        "enable" => false,
        "channel" => "NotificationChannels\AllMySms\AllMySmsChannel",
        "sdk" => [
            'laravel-notification-channels/46elks'
        ],
        "env" => [
            'ALL_MY_SMS_URI',
            'ALL_MY_SMS_LOGIN',
            'ALL_MY_SMS_API_KEY',
            'ALL_MY_SMS_FORMAT',
            'ALL_MY_SMS_SENDER',
            'ALL_MY_SMS_UNIVERSAL_TO',
        ],
        "config" => [
            'uri' => env('ALL_MY_SMS_URI', 'https://api.allmysms.com/http/9.0'),
            'login' => env('ALL_MY_SMS_LOGIN'),
            'api_key' => env('ALL_MY_SMS_API_KEY'),
            'format' => env('ALL_MY_SMS_FORMAT', 'json'),
            'sender' => env('ALL_MY_SMS_SENDER'),
            'universal_to' => env('ALL_MY_SMS_UNIVERSAL_TO'),
        ]
    ],
    [
        "slug" => "smspoh",
        "name" => "Smspoh",
        "config-key" => "smspoh",
        "enable" => false,
        "channel" => "smspoh",
        "sdk" => [
            'laravel-notification-channels/46elks'
        ],
        "env" => [
            'SMSPOH_ENDPOINT',
            'SMSPOH_TOKEN',
            'SMSPOH_SENDER',
        ],
        "config" => [
            'endpoint' => env('SMSPOH_ENDPOINT', 'https://smspoh.com/api/v2/send'),
            'token' => env('SMSPOH_TOKEN', 'YOUR SMSPOH TOKEN HERE'),
            'sender' => env('SMSPOH_SENDER', 'YOUR SMSPOH SENDER HERE')
        ]
    ],
    [
        "slug" => "turbosms",
        "name" => "TurboSMS",
        "config-key" => "turbosms",
        "enable" => false,
        "channel" => "turbosms",
        "sdk" => [
            'laravel-notification-channels/turbosms'
        ],
        "env" => [
            'TURBOSMS_WSDLENDPOINT',
            'TURBOSMS_LOGIN',
            'TURBOSMS_PASSWORD',
            'TURBOSMS_SENDER',
            'TURBOSMS_DEBUG',
            'TURBOSMS_SANDBOX_MODE',
        ],
        "config" => [
            'wsdlEndpoint' => env('TURBOSMS_WSDLENDPOINT', 'http://turbosms.in.ua/api/wsdl.html'),
            'login' => env('TURBOSMS_LOGIN'),
            'password' => env('TURBOSMS_PASSWORD'),
            'sender' => env('TURBOSMS_SENDER'),
            'debug' => env('TURBOSMS_DEBUG', false), //will log sending attempts and results
            'sandboxMode' => env('TURBOSMS_SANDBOX_MODE', false) //will not invoke API call
        ]
    ],
    [
        "slug" => "vodafone",
        "name" => "Vodafone",
        "config-key" => "vodafone",
        "enable" => false,
        "channel" => "NotificationChannels\Vodafone\VodafoneChannel",
        "sdk" => [
            'laravel-notification-channels/vodafone'
        ],
        "env" => [
            'VODAFONE_USERNAME',
            'VODAFONE_PASSWORD',
        ],
        "config" => [
            'username' => env('VODAFONE_USERNAME'),
            'password' => env('VODAFONE_PASSWORD'),
        ]
    ],
    [
        "slug" => "africastalking",
        "name" => "AfricasTalking",
        "config-key" => "africastalking",
        "enable" => false,
        "channel" => "NotificationChannels\AfricasTalking\AfricasTalkingChannel",
        "sdk" => [
            'laravel-notification-channels/africastalking'
        ],
        "env" => [
            'AT_USERNAME',
            'AT_KEY',
            'AT_FROM',
        ],
        "config" => [
            'username' => env('AT_USERNAME'),
            'key' => env('AT_KEY'),
            'from' => env('AT_FROM'),
        ]
    ],
    [
        "slug" => "sms77",
        "name" => "SMS77",
        "config-key" => "sms77",
        "enable" => false,
        "channel" => "NotificationChannels\SMS77\SMS77Channel",
        "sdk" => [
            'laravel-notification-channels/sms77'
        ],
        "env" => [
            'SMS77_API_KEY',
        ],
        "config" => [
            'api_key' => env('SMS77_API_KEY')
        ]
    ],
    [
        "slug" => "smsapi",
        "name" => "SMSAPI",
        "config-key" => "smsapi",
        "enable" => false,
        "channel" => "NotificationChannels\Smsapi\SmsapiChannel",
        "sdk" => [
            'laravel-notification-channels/smsapi'
        ],
        "env" => [
            'SMSAPI_AUTH_TOKEN',
        ],
        "config" => [
            'token' => env('SMSAPI_AUTH_TOKEN'),
        ]
    ],
    [
        "slug" => "sms-broadcast",
        "name" => "SMSbroadcast",
        "config-key" => "smsbroadcast",
        "enable" => false,
        "channel" => "NotificationChannels\SmsBroadcast\SmsBroadcastChannel",
        "sdk" => [
            'laravel-notification-channels/sms-broadcast'
        ],
        "env" => [
            'SMS_BROADCAST_USERNAME',
            'SMS_BROADCAST_PASSWORD',
            'SMS_BROADCAST_DEFAULT_SENDER',
        ],
        "config" => [
            'username' => env('SMS_BROADCAST_USERNAME'),
            'password' => env('SMS_BROADCAST_PASSWORD'),
            'default_sender' => env('SMS_BROADCAST_DEFAULT_SENDER', null),
        ]
    ],
    [
        "slug" => "nexmo",
        "name" => "nexmo",
        "config-key" => "nexmo",
        "enable" => true,
        "channel" => "nexmo",
        "sdk" => [
            'laravel/nexmo-notification-channel',
            'nexmo/laravel',
        ],
        "env" => [
            'NEXMO_KEY',
            'NEXMO_SECRET',
        ],
        "config" => [
            'sms_from' => '15556666666',
        ]
    ]
];
