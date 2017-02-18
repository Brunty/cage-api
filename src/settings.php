<?php
return [
    'settings' => [
        'displayErrorDetails'    => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer'               => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger'                 => [
            'name'  => 'slim-app',
            'path'  => __DIR__ . '/../var/logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
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
