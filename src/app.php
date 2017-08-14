<?php

require __DIR__ . '/../vendor/autoload.php';

if ( ! getenv('APP_ENV')) {
    (new \Dotenv\Dotenv(__DIR__ . '/../'))->load();
}

define('APP_ENV', getenv('APP_ENV'));

$baseSettings = include __DIR__ . '/../config/settings.php';
$envSettings = require __DIR__ . '/../config/' . APP_ENV . '/settings.php';

$settings = array_replace_recursive($baseSettings, $envSettings);

// Instantiate the app
$app = new \App\Kernel($settings, APP_ENV);
$app->loadConfig(__DIR__ . '/../config/');

return $app;
