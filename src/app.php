<?php

require __DIR__ . '/../vendor/autoload.php';

(new \Dotenv\Dotenv(__DIR__ . '/../'))->load();

if (getenv('APP_ENV') === false) {
    putenv('APP_ENV=dev');
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
