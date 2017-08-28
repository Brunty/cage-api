<?php

require __DIR__ . '/../vendor/autoload.php';

$host = WEB_SERVER_HOST;
$port = WEB_SERVER_PORT;
$docroot = WEB_SERVER_DOCROOT;
$appEnv = getenv('APP_ENV');

$command = "APP_ENV={$appEnv} php -S {$host}:{$port} -t {$docroot} >/dev/null 2>&1 & echo $!";

$output = [];
exec($command, $output);
$pid = (int) $output[0];

$date = date('r');

register_shutdown_function(function () use ($pid) {
    exec('kill ' . $pid);
});
