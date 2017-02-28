<?php

use Interop\Container\ContainerInterface;

/*
 * I'm not importing many things here purely so it's easier to see the namespace
 * of where things are coming from in each container binding.
 */

$container = $app->getContainer();

// 'Domain' type stuff
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

/**
 * @var \App\Domain\Event\EventDispatcher $dispatcher
 */
$dispatcher = $container->get(\App\Domain\Event\EventDispatcher::class);

// Events
$dispatcher->addListener(
    \App\Domain\Event\RandomCageImageViewed::class,
    new \App\Infrastructure\Event\Listener\ImageViewedListener($container->get(Psr\Log\LoggerInterface::class))
);
