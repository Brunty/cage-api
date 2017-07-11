<?php

require __DIR__ . '/../vendor/autoload.php';

$host = WEB_SERVER_HOST;
$port = WEB_SERVER_PORT;
$docroot = WEB_SERVER_DOCROOT;

$command = "php -S {$host}:{$port} -t {$docroot} >/dev/null 2>&1 & echo $!";

$output = [];
exec($command, $output);
$pid = (int) $output[0];

$date = date('r');

echo "{$date} - Web server started on {$host}:{$port} with PID {$pid}" . PHP_EOL;

register_shutdown_function(function() use ($pid) {
    $date = date('r');
    echo "{$date} - Killing process with ID {$pid}" . PHP_EOL;
    exec('kill ' . $pid);
});
