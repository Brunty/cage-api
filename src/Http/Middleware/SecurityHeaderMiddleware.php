<?php
declare(strict_types = 1);

namespace App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SecurityHeaderMiddleware
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

        $response = $response->withHeader('X-Random-Chars', $headerString)
                             ->withHeader('Content-Security-Policy', 'upgrade-insecure-requests;')
                             ->withHeader('X-Content-Type-Options', 'nosniff')
                             ->withHeader('X-Frame-Options', 'DENY')
                             ->withHeader('X-XSS-Protection', '1; mode=block')
                             ->withHeader('Referrer-Policy', 'same-origin')
                             ->withHeader('Strict-Transport-Security', 'max-age=63072000')
                             ->withHeader('X-Clacks-Overhead', 'GNU Terry Pratchett');

        return $next($request, $response);
    }
}
