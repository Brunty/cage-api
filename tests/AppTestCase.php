<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Slim\App;

class AppTestCase extends TestCase
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var App
     */
    protected $app;

    public function setUp()
    {
        $settings = require __DIR__ . '/../src/settings.php';
        $app = new App($settings);
        require __DIR__ . '/../src/dependencies.php';
        require __DIR__ . '/../src/middleware.php';
        require __DIR__ . '/../src/routes.php';

        $this->app = $app;
        $this->container = $this->app->getContainer();
    }
}
