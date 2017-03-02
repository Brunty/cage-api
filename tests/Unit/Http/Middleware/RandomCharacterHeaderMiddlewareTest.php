<?php

namespace Tests\Unit\Http\Middleware;

use App\Http\Middleware\RandomCharacterHeaderMiddleware;
use PHPUnit\Framework\TestCase;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Stream;
use Slim\Http\Uri;

class RandomCharacterHeaderMiddlewareTest extends TestCase
{

    /**
     * @test
     */
    public function it_adds_the_header_to_the_response()
    {
        $request = new Request(
            'GET',
            new Uri('', ''),
            new Headers([]),
            [],
            [],
            new Stream(stream_context_create([]))
        );
        $response = new Response;
        $middleware = new RandomCharacterHeaderMiddleware;

        $middlewareResponse = $middleware(
            $request,
            $response,
            function ($request, $response) {
                return $response;
            }
        );


        self::assertTrue(strlen($middlewareResponse->getHeader('X-Random-Chars')[0]) > 0);
    }
}
