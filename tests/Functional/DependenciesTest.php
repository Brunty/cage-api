<?php

namespace Tests\Functional;

use App\Domain\Event\EventDispatcher;
use App\Domain\Repository\CageRepository;
use App\Http\Action\Page\HomepageAction;
use App\Http\Action\RandomCage\MultipleImageAction;
use App\Http\Action\RandomCage\SingleImageAction;
use App\Http\Negotiator\AcceptHeaderNegotiator;
use App\Http\Responder\Page\Homepage\HomepageResponder;
use App\Http\Responder\RandomCage\MultipleImage\MultipleImageResponder;
use App\Http\Responder\RandomCage\SingleImage\SingleImageResponder;
use App\Presentation\Page\Homepage\ContentCreator as HomepageContentCreator;
use App\Presentation\RandomCage\SingleImage\ContentCreator as SingleImageContentCreator;
use App\Presentation\RandomCage\MultipleImage\ContentCreator as MultipleImageContentCreator;
use Interop\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Slim\App;
use Slim\Views\Twig;

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
            ['app.random_cage.multiple_image_responder', MultipleImageResponder::class],
            ['view', Twig::class],
            ['logger', LoggerInterface::class],
            ['app.repository.cage', CageRepository::class],
            ['app.event_dispatcher', EventDispatcher::class],
            ['app.accept_header_negotiator', AcceptHeaderNegotiator::class],
            ['app.homepage_content_creator', HomepageContentCreator::class],
            ['app.page.homepage_responder', HomepageResponder::class],
            ['app.http.page.homepage', HomepageAction::class],
            ['app.random_cage.single_image_responder', SingleImageResponder::class],
            ['app.http.random_cage.single_image', SingleImageAction::class],
            ['app.random_cage.multiple_image_responder', MultipleImageResponder::class],
            ['app.http.random_cage.multiple_image', MultipleImageAction::class],
        ];
    }
}
