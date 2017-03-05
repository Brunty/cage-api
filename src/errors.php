<?php

use App\Http\Negotiator\UnacceptableContentTypeException;
use App\Infrastructure\Error\ErrorHandler;
use App\Infrastructure\Error\UnacceptableContentTypeHandler;
use Psr\Container\ContainerInterface;

$container = $app->getContainer();

$container['errorHandler'] = function (ContainerInterface $c) {
    return new ErrorHandler(
        $c->get('settings')['displayErrorDetails'],
        [
            UnacceptableContentTypeException::class => new UnacceptableContentTypeHandler(
                $c->get('settings')['api']['content_types']
            )
        ]
    );
};
