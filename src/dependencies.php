<?php

use Interop\Container\ContainerInterface;

/*
 * I'm not importing many things here purely so it's easier to see the namespace
 * of where things are coming from in each container binding.
 */

$container = $app->getContainer();


// Register Twig View helper
$container['view'] = function (ContainerInterface $c) {

    $settings = $c->get('settings')['view'];

    $view = new \Slim\Views\Twig($settings['templates'], [
        'cache' => $settings['cache']
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($c['router'], $basePath));

    return $view;
};

$container[\Psr\Log\LoggerInterface::class] = function (ContainerInterface $c) {
    $settings = $c->get('settings')['logger'];
    $logger = new \Monolog\Logger($settings['name']);
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));

    return $logger;
};

$container[\App\Domain\Repository\CageRepository::class] = function (ContainerInterface $c) {
    return new \App\Infrastructure\Repository\JsonFileCageRepository($c->get('settings')['storage']['cage_file_path']);
};

$container[\App\Domain\Event\EventDispatcher::class] = function (ContainerInterface $c) {
    return new \App\Infrastructure\Event\LeagueEventDispatcher(new \League\Event\Emitter);
};

// HTTP layer stuff
$container[\App\Http\Negotiator\AcceptHeaderNegotiator::class] = function () {
    return new \App\Http\Negotiator\AuraAcceptHeaderNegotiator(
        (new \Aura\Accept\AcceptFactory($_SERVER))->newInstance()
    );
};

/*
 * HOMEPAGE
 */

$container[\App\Presentation\Page\Homepage\ContentCreator::class] = function (ContainerInterface $c) {
    return new \App\Presentation\Page\Homepage\ContentCreator($c->get('view'));
};

$container[\App\Http\Responder\Page\Homepage\HomepageResponder::class] = function (ContainerInterface $c) {
    return new \App\Http\Responder\Page\Homepage\HomepageResponder($c->get(\App\Presentation\Page\Homepage\ContentCreator::class));
};

$container[\App\Http\Action\Page\HomepageAction::class] = function (ContainerInterface $c) {
    return new \App\Http\Action\Page\HomepageAction($c->get(\App\Http\Responder\Page\Homepage\HomepageResponder::class));
};

/*
 * SINGLE IMAGES
 */
$container[\App\Http\Responder\RandomCage\SingleImage\SingleImageResponder::class] = function (ContainerInterface $c) {
    return new \App\Http\Responder\RandomCage\SingleImage\SingleImageResponder(
        new \App\Presentation\RandomCage\SingleImage\ContentCreator,
        $c->get(\App\Http\Negotiator\AcceptHeaderNegotiator::class),
        $c->get('settings')['api']['content_types']
    );
};

$container[\App\Http\Action\RandomCage\SingleImageAction::class] = function (ContainerInterface $c) {
    return new \App\Http\Action\RandomCage\SingleImageAction(
        new \App\Infrastructure\Repository\EventDispatchingJsonFileCageRepository(
            $c->get(\App\Domain\Repository\CageRepository::class), $c->get(\App\Domain\Event\EventDispatcher::class)
        ),
        $c->get(\App\Http\Responder\RandomCage\SingleImage\SingleImageResponder::class)
    );
};


/*
 * MULTIPLE IMAGES
 */

$container[\App\Http\Responder\RandomCage\MultipleImage\MultipleImageResponder::class] = function (ContainerInterface $c) {
    return new \App\Http\Responder\RandomCage\MultipleImage\MultipleImageResponder(
        new \App\Presentation\RandomCage\MultipleImage\ContentCreator,
        $c->get(\App\Http\Negotiator\AcceptHeaderNegotiator::class),
        $c->get('settings')['api']['content_types']
    );
};

$container[\App\Http\Action\RandomCage\MultipleImageAction::class] = function (ContainerInterface $c) {
    return new \App\Http\Action\RandomCage\MultipleImageAction(
        new \App\Infrastructure\Repository\EventDispatchingJsonFileCageRepository(
            $c->get(\App\Domain\Repository\CageRepository::class), $c->get(\App\Domain\Event\EventDispatcher::class)
        ),
        $c->get(\App\Http\Responder\RandomCage\MultipleImage\MultipleImageResponder::class)
    );
};


/**
 * @var \App\Domain\Event\EventDispatcher $dispatcher
 */
$dispatcher = $container->get(\App\Domain\Event\EventDispatcher::class);

// Events
$dispatcher->addListener(
    \App\Domain\Event\RandomCageImageViewed::class,
    new \App\Infrastructure\Event\Listener\ImageViewedListener($container->get(Psr\Log\LoggerInterface::class))
);
