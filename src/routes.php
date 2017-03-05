<?php

use App\Http\Middleware\AcceptHeaderMiddleware;

$container = $app->getContainer();

$app->get('/', 'app.http.page.homepage');
$app->group(
    '',
    function () {
        $this->get('/random', 'app.http.random_cage.single_image');
        $this->get('/bomb/{number}', 'app.http.random_cage.multiple_image');
    }
)->add(
    new AcceptHeaderMiddleware(
        $container->get('app.accept_header_negotiator'),
        $container->get('settings')['api']['content_types']
    )
);
