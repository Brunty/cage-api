<?php
$base = include __DIR__ . '/settings.php';

return array_replace_recursive($base, [
    'settings' => [
        'displayErrorDetails' => false,
        'logger' => [
            'path' => 'php://stderr',
            'level' => \Monolog\Logger::ERROR,
        ],
        'view' => [
            'cache' => __DIR__ . '/../var/storage/cache/templates',
        ],
    ],
]);
