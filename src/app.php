<?php

require __DIR__ . '/../vendor/autoload.php';

if ( ! getenv('APP_ENV')) {
    (new \Dotenv\Dotenv(__DIR__ . '/../'))->load();
}

define('APP_ENV', getenv('APP_ENV'));

// Instantiate the app
$settings = require __DIR__ . '/settings.' . APP_ENV . '.php';
$app = new \Slim\App($settings);

require __DIR__ . '/errors.php';
require __DIR__ . '/dependencies.php';
require __DIR__ . '/middleware.php';
require __DIR__ . '/routes.php';

return $app;
