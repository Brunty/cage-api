<?php
// Routes

use App\Http\Action\RandomCage\MultipleImageAction;
use App\Http\Action\RandomCage\SingleImageAction;
use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("BEHOLD, THE ONE TRUE GOD.");

    return $response;
});

$app->get('/random', SingleImageAction::class);

$app->get('/random/{number}', MultipleImageAction::class);
