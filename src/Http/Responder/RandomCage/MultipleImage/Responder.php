<?php
declare(strict_types = 1);

namespace App\Http\Responder\RandomCage\MultipleImage;

use App\Domain\Collection\ImageCollection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface Responder
{

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        ImageCollection $images
    ): ResponseInterface;

    public function setException(\Throwable $exception);
}
