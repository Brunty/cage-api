<?php
// Routes

use App\Domain\Repository\CageRepository;
use App\Http\RandomCage\SingleImageAction;
use Slim\Http\Response;

$app->get('/random', SingleImageAction::class);


$app->get('/random/{number}', function($request, Response $response, $args) {
    /** @var CageRepository $repo */
    $repo = $this->get(CageRepository::class);
    return $response->withJson(['images' => $repo->getRandomCageImages($args['number'])]);
});
