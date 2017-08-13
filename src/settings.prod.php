<?php
$config = include __DIR__ . '/settings.php';

$config['settings']['displayErrorDetails'] = false;
$config['settings']['logger']['path'] = 'php://stderr';
$config['settings']['logger']['level'] = \Monolog\Logger::ERROR;
$config['settings']['view']['cache'] = __DIR__ . '/../var/storage/cache/templates';

return $config;
