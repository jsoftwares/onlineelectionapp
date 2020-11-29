<?php

return [

    'sms' => [

        //API keys for SMS financial and promotional routes
        'financial_token' => env('SMS_API_KEY_CORPR'),
        'promotion_token' => env('SMS_API_KEY_PROMR'),

        //SMS endpoints
        'single_api' => env('SMS_API_SINGLE'),
        'advanced_api' => env('SMS_API_ADVANCED')
    ],

    // 'redis_mode' => [
    //     'apply' => env('REDIS_SCAFOLDING')
    // ]
    
];