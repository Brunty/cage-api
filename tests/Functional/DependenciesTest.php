<?php

namespace Tests\Functional;

use App\Http\Responder\RandomCage\MultipleImage\MultipleImageResponder;
use Interop\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;
use Slim\App;

class DependenciesTest extends TestCase
{

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setUp()
    {
        // Instantiate the app
        $settings = require __DIR__ . '/../../src/settings.php';
        $app = new App($settings);

        // Set up dependencies
        require __DIR__ . '/../../src/dependencies.php';
        $this->container = $app->getContainer();
    }

    /**
     * @test
     * @dataProvider provider_for_it_resolves_the_correct_things_from_the_container
     *
     * @param string $alias
     * @param string $class
     */
    public function it_resolves_the_correct_things_from_the_container(string $alias, string $class)
    {
        $item = $this->container->get($alias);
        self::assertInstanceOf($class, $item);
    }

    public function provider_for_it_resolves_the_correct_things_from_the_container(): array
    {
        return [
            ['app.random_cage.multiple_image_responder', MultipleImageResponder::class]
        ];
    }
}
