<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'openWeather'=>[
        'openWeatherKey' => [
            'key' => env('OPENWEATHERMAP_API_KEY', '858f15fed9292cbe25c341a754c55e45'),
        ],
        'openWeatherUnits' => 'metric',
        'openWeatherDataUrl' => [
            'weather' => 'https://api.openweathermap.org/data/2.5/weather',
            'forecast' => 'https://api.openweathermap.org/data/2.5/onecall',
//            'forecast' => 'https://api.openweathermap.org/data/2.5/forecast',
        ]
    ]

];
