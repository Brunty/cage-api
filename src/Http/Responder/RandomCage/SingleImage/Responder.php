<?php

namespace App\Http\Responder\RandomCage\SingleImage;

use App\Domain\Model\Image;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface Responder
{

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        Image $image
    ): ResponseInterface;
}
