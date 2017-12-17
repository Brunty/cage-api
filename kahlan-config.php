<?php

use Brunty\Kahlan\Mink\Mink;
use Brunty\Kahlan\Mink\PhpServer;
use function Kahlan\box;

Mink::register($this);
PhpServer::register($this);

box('app.url', 'http://localhost:8888');
box('brunty.kahlan-mink.base-url', 'http://localhost:8888');
