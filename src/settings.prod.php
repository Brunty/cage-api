<?php
$base = include __DIR__ . '/settings.php';

return [
    'settings' => [
        'displayErrorDetails' => false,
        'logger'              => [
            'path'  => 'php://stderr',
            'level' => \Monolog\Logger::ERROR,
        ],
        'view' => [
            'cache'     => '/../var/storage/cache/templates',
        ],
    ],
] + $base;
