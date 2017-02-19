<?php
// Routes

use App\Domain\Repository\CageRepository;
use App\Http\Action\RandomCage\SingleImageAction;
use Slim\Http\Response;

$app->get('/random', SingleImageAction::class);
