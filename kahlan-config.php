<?php

use function Kahlan\box;

require __DIR__ . '/vendor/autoload.php';

\App\Spec\Mink::register($this);
\App\Spec\PhpServer::register($this);

box('app.url', 'http://localhost:8888');
