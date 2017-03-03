<?php

use App\Http\Action\Page\HomepageAction;
use App\Http\Action\RandomCage\MultipleImageAction;
use App\Http\Action\RandomCage\SingleImageAction;

$app->get('/', HomepageAction::class);
$app->get('/random', SingleImageAction::class);
$app->get('/random/{number}', MultipleImageAction::class);
