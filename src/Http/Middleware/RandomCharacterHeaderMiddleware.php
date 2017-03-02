<?php

namespace App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RandomCharacterHeaderMiddleware
{

    /**
     * Adds a random number of characters to the response header to reduce content length guessing of responses
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $response = $next($request, $response);

        $headerString = '';
        $length = random_int(1, 128);

        while (strlen($headerString) < $length) {
            $headerString .= 'A';
        }

        return $response->withHeader('X-Random-Chars', $headerString);
    }
}
