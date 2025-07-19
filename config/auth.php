<?php

return [

    'defaults' => [
        'guard' => 'web',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session', // o token
            'provider' => 'users',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    ],

];