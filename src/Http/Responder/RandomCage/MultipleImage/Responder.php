<?php
declare(strict_types=1);

namespace App\Http\Responder\RandomCage\MultipleImage;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface Responder
{

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $images
    ): ResponseInterface;

    public function setException(\Throwable $exception);
}
