<?php

use App\Domain\Event\CageImageAccessed;
use App\Http\Action\Page\HomepageAction;
use App\Http\Action\RandomCage\MultipleImageAction;
use App\Http\Action\RandomCage\SingleImageAction;
use App\Http\Negotiator\AuraAcceptHeaderNegotiator;
use App\Http\Responder\Page\Homepage\HomepageResponder;
use App\Http\Responder\RandomCage\MultipleImage\MultipleImageResponder;
use App\Http\Responder\RandomCage\SingleImage\SingleImageResponder;
use App\Infrastructure\Event\LeagueEventDispatcher;
use App\Infrastructure\Event\Listener\ImageViewedListener;
use App\Infrastructure\Repository\EventDispatchingCageRepository;
use App\Infrastructure\Repository\JsonFileCageRepository;
use App\Presentation\Page\Homepage\ContentCreator as HomepageContentCreator;
use App\Presentation\RandomCage\SingleImage\ContentCreator as SingleImageContentCreator;
use App\Presentation\RandomCage\MultipleImage\ContentCreator as MultipleImageContentCreator;
use Aura\Accept\AcceptFactory;
use Interop\Container\ContainerInterface;
use League\Event\Emitter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

$container = $app->getContainer();

$container['view'] = function (ContainerInterface $c) {

    $settings = $c->get('settings')['view'];

    $view = new Twig(
        $settings['templates'], [
            'cache' => $settings['cache']
        ]
    );

    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new TwigExtension($c['router'], $basePath));

    return $view;
};

$container['logger'] = function (ContainerInterface $c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Logger($settings['name']);
    $logger->pushProcessor(new UidProcessor());
    $logger->pushHandler(new StreamHandler($settings['path'], $settings['level']));

    return $logger;
};

$container['app.repository.cage'] = function (ContainerInterface $c) {
    return new JsonFileCageRepository($c->get('settings')['storage']['cage_file_path']);
};

$container['app.event_dispatcher'] = function (ContainerInterface $c) {
    return new LeagueEventDispatcher(new Emitter);
};

$container['app.accept_header_negotiator'] = function () {
    return new AuraAcceptHeaderNegotiator((new AcceptFactory($_SERVER))->newInstance());
};

$container['app.homepage_content_creator'] = function (ContainerInterface $c) {
    return new HomepageContentCreator($c->get('view'));
};

$container['app.page.homepage_responder'] = function (ContainerInterface $c) {
    return new HomepageResponder($c->get('app.homepage_content_creator'));
};

$container['app.http.page.homepage'] = function (ContainerInterface $c) {
    return new HomepageAction($c->get('app.page.homepage_responder'));
};

$container['app.random_cage.single_image_responder'] = function (ContainerInterface $c) {
    return new SingleImageResponder(
        new SingleImageContentCreator,
        $c->get('app.accept_header_negotiator'),
        $c->get('settings')['api']['content_types']
    );
};

$container['app.http.random_cage.single_image'] = function (ContainerInterface $c) {
    return new SingleImageAction(
        new EventDispatchingCageRepository(
            $c->get('app.repository.cage'),
            $c->get('app.event_dispatcher')
        ),
        $c->get('app.random_cage.single_image_responder')
    );
};

$container['app.random_cage.multiple_image_responder'] = function (ContainerInterface $c) {
    return new MultipleImageResponder(new MultipleImageContentCreator);
};

$container['app.http.random_cage.multiple_image'] = function (ContainerInterface $c) {
    return new MultipleImageAction(
        $c->get('app.repository.cage'),
        $c->get('app.random_cage.multiple_image_responder')
    );
};

/**
 * @var \App\Domain\Event\EventDispatcher $dispatcher
 */
$dispatcher = $container->get('app.event_dispatcher');

// Events
$dispatcher->addListener(CageImageAccessed::class, new ImageViewedListener($container->get('logger')));


