<?php
return [
    'settings' => [
        'displayErrorDetails' => getenv('APP_ENVIRONMENT') === 'prod' ? false : true, // set to false in production

        // Monolog settings
        'logger'              => [
            'name'  => 'slim-app',
            'path'  => __DIR__ . '/../var/logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        'view' => [
            'templates' => __DIR__ . '/../src/Presentation/Views',
            'cache'     => getenv('APP_ENVIRONMENT') === 'prod' ? __DIR__ . '/../var/storage/cache/templates' : false,
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
