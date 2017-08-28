<?php

namespace Tests;

use App\Kernel;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;

class AppTestCase extends TestCase
{

    /**
     * Use middleware when running application?
     *
     * @var bool
     */
    protected $withMiddleware = true;

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
        (new Dotenv(__DIR__ . '/../', '.env.test'))->load();

        if (getenv('APP_ENV') === false) {
            putenv('APP_ENV=test');
        }

        if( ! defined('APP_ENV')) {
            define('APP_ENV', getenv('APP_ENV'));
        }

        $baseSettings = include __DIR__ . '/../config/settings.php';
        $envSettings = require __DIR__ . '/../config/' . APP_ENV . '/settings.php';
        $settings = array_replace_recursive($baseSettings, $envSettings);

        // Instantiate the app
        $app = new Kernel($settings, APP_ENV);
        $app->loadConfig(__DIR__ . '/../config/');

        $this->app = $app;
        $this->container = $this->app->getContainer();
    }

    /**
     * Process the application given a request method and URI
     *
     * @param string            $requestMethod the request method (e.g. GET, POST, etc.)
     * @param string            $requestUri    the request URI
     * @param array|object|null $requestData   the request data
     *
     * @return \Slim\Http\Response
     */
    public function runApp($requestMethod, $requestUri, $requestData = null)
    {
        // Create a mock environment for testing with
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' => $requestMethod,
                'REQUEST_URI'    => $requestUri
            ]
        );
        // Set up a request object based on the environment
        $request = Request::createFromEnvironment($environment);
        // Add request data, if it exists
        if ($requestData === null) {
            $request = $request->withParsedBody($requestData);
        }
        // Set up a response object
        $response = new Response();
        // Use the application settings
        $settings = require __DIR__ . '/../src/settings.php';
        // Instantiate the application
        $app = new App($settings);
        // Set up dependencies
        require __DIR__ . '/../src/dependencies.php';
        // Register middleware
        if ($this->withMiddleware) {
            require __DIR__ . '/../src/middleware.php';
        }
        // Register routes
        require __DIR__ . '/../src/routes.php';
        // Process the application
        $response = $app->process($request, $response);

        // Return the response
        return $response;
    }
}
