<?php

return [
    'settings' => [
        'displayErrorDetails' => false,
        'logger' => [
            'path' => 'php://stderr',
            'level' => \Monolog\Logger::ERROR,
        ],
        'view' => [
            'cache' => __DIR__ . '/../../var/storage/cache/' . APP_ENV . '/templates',
        ],
    ],
];
