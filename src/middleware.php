<?php

use App\Http\Middleware\RandomCharacterHeaderMiddleware;

$app->add(new RandomCharacterHeaderMiddleware);
