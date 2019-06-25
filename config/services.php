<?php

return [
    
    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */
    
    'mailgun' => [
        'domain' => null,
        'secret' => null,
        'guzzle' => [
            'verify' => false,
        ],
    ],
    
    'mandrill' => [
        'secret' => null,
        'guzzle' => [
            'verify' => false,
        ],
    ],
    
    'ses' => [
        'key' => null,
        'secret' => null,
        'region' => null,
    ],
    
    'sparkpost' => [
        'secret' => null,
        'guzzle' => [
            'verify' => false,
        ],
    ],
    
    'stripe' => [
        'model' => App\Larapen\Models\User::class,
        'key' => null,
        'secret' => null,
    ],
    
    'paypal' => [
        'mode' => 'sandbox',
        'username' => null,
        'password' => null,
        'signature' => null,
    ],
    
    'facebook' => [
        'client_id' => null,
        'client_secret' => null,
        'redirect' => env('APP_URL') . '/auth/facebook/callback',
    ],
    
    'google' => [
        'client_id' => null,
        'client_secret' => null,
        'redirect' => env('APP_URL') . '/auth/google/callback',
    ],
    
    'twitter' => [
        'client_id' => null,
        'client_secret' => null,
        'redirect' => env('APP_URL') . '/auth/twitter/callback',
    ],
    
    'googlemaps' => [
        'key' => null, //-> for Google Map JavaScript & Embeded
    ],

];
