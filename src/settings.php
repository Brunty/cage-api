<?php
return [
    'settings' => [
        'displayErrorDetails' => true,

        'logger'              => [
            'name'  => 'cage.app',
            'path'  => __DIR__ . '/../var/logs/' . APP_ENV . '.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        'view' => [
            'templates' => __DIR__ . '/../src/Presentation/Views',
            'cache'     => false,
        ],

        'storage' => [
            'cage_file_path' => __DIR__ . '/../var/storage/cages.json'
        ],

        'api' => [
            'content_types' => [
                'application/json',
                'application/xml'
            ]
        ]
    ],
];
