<?php
declare(strict_types = 1);

namespace App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RandomCharacterHeaderMiddleware
{

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface {
        $headerString = '';
        $length = random_int(1, 1024);

        while (strlen($headerString) < $length) {
            $headerString .= 'A';
        }

        $response = $response->withHeader('X-Random-Chars', $headerString);

        return $next($request, $response);
    }
}
