<?php

use App\Api\Http\RandomCage\SingleImageAction;
use App\Api\Responder\RandomCage\SingleImageResponder;
use App\Domain\Repository\CageRepository;
use App\Infrastructure\Negotiator\AcceptHeaderNegotiator;
use App\Infrastructure\Repository\JsonFileCageRepository;
use Interop\Container\ContainerInterface;

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

$container[AcceptHeaderNegotiator::class] = function (ContainerInterface $c) {
    return new \App\Infrastructure\Negotiator\AuraAcceptHeaderNegotiator(
        (new \Aura\Accept\AcceptFactory($_SERVER))->newInstance()
    );
};

$container[CageRepository::class] = function (ContainerInterface $c) {
    return new JsonFileCageRepository($c->get('settings')['storage']['cage_file_path']);
};

$container[SingleImageResponder::class] = function (ContainerInterface $c) {
    return new SingleImageResponder($c->get(AcceptHeaderNegotiator::class));
};

$container[SingleImageAction::class] = function (ContainerInterface $c) {
    return new SingleImageAction($c->get(CageRepository::class), $c->get(SingleImageResponder::class));
};
