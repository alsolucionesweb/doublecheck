<?php

return [
    'default' => env('FILESYSTEM_DRIVER', 'local'),

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],
        'public_img' => [
            'driver' => 'local',
            'root'   => base_path('public/img/candidatos'),
            'visibility' => 'public',
        ],
        'public_doc' => [
            'driver' => 'local',
            'root'   => base_path('public/descargable'),
            'visibility' => 'public',
        ],
    ],
];
