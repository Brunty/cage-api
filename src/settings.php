<?php
return [
    'settings' => [
        'displayErrorDetails' => getenv('APP_ENV') !== 'prod', // set to false in production

        // Monolog settings
        'logger'              => [
            'name'  => 'slim-app',
            'path'  => 'php://stderr',
            'level' => \Monolog\Logger::DEBUG,
        ],

        'view' => [
            'templates' => __DIR__ . '/../src/Presentation/Views',
            'cache'     => getenv('APP_ENV') === 'prod' ? __DIR__ . '/../var/storage/cache/templates' : false,
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
