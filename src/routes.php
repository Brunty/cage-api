<?php

use App\Http\Action\RandomCage\MultipleImageAction;
use App\Http\Action\RandomCage\SingleImageAction;

$app->get('/', 'app.http.page.homepage');
$app->get('/random', 'app.http.random_cage.single_image');
$app->get('/bomb/{number}', 'app.http.random_cage.multiple_image');
