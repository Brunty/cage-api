<?php

use Interop\Container\ContainerInterface;

/*
 * I'm not importing many things here purely so it's easier to see the namespace
 * of where things are coming from in each container binding.
 */

$container = $app->getContainer();

$container['renderer'] = function (ContainerInterface $c) {
    $settings = $c->get('settings')['renderer'];

    return new Slim\Views\PhpRenderer($settings['template_path']);
};

$container['logger'] = function (ContainerInterface $c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));

    return $logger;
};

$container[App\Api\Negotiator\AcceptHeaderNegotiator::class] = function () {
    return new App\Api\Negotiator\AuraAcceptHeaderNegotiator(
        (new Aura\Accept\AcceptFactory($_SERVER))->newInstance()
    );
};

$container[App\Domain\Repository\CageRepository::class] = function (ContainerInterface $c) {
    return new App\Infrastructure\Repository\JsonFileCageRepository($c->get('settings')['storage']['cage_file_path']);
};

$container[App\Api\Responder\RandomCage\SingleImageResponder::class] = function (ContainerInterface $c) {
    return new App\Api\Responder\RandomCage\SingleImageResponder(
        $c->get(App\Api\Negotiator\AcceptHeaderNegotiator::class),
        $c->get('settings')['api']['content_types']
    );
};

$container[App\Api\Http\RandomCage\SingleImageAction::class] = function (ContainerInterface $c) {
    return new App\Api\Http\RandomCage\SingleImageAction(
        $c->get(App\Domain\Repository\CageRepository::class),
        $c->get(App\Api\Responder\RandomCage\SingleImageResponder::class)
    );
};
