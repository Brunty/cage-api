<?php

namespace Tests\Unit\Http\Middleware;

use App\Http\Middleware\SecurityHeaderMiddleware;
use PHPUnit\Framework\TestCase;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Stream;
use Slim\Http\Uri;

class SecurityHeaderMiddlewareTest extends TestCase
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
        $middleware = new SecurityHeaderMiddleware;

        $middlewareResponse = $middleware(
            $request,
            $response,
            function ($request, $response) {
                return $response;
            }
        );


        self::assertTrue(strlen($middlewareResponse->getHeader('X-Random-Chars')[0]) > 0);
        self::assertEquals($middlewareResponse->getHeader('Content-Security-Policy')[0], 'upgrade-insecure-requests;');
        self::assertEquals($middlewareResponse->getHeader('X-Content-Type-Options')[0], 'nosniff');
        self::assertEquals($middlewareResponse->getHeader('X-Frame-Options')[0], 'DENY');
        self::assertEquals($middlewareResponse->getHeader('X-XSS-Protection')[0], '1; mode=block');
        self::assertEquals($middlewareResponse->getHeader('Referrer-Policy')[0], 'same-origin');
        self::assertEquals($middlewareResponse->getHeader('Strict-Transport-Security')[0], 'max-age=63072000');
        self::assertEquals($middlewareResponse->getHeader('X-Clacks-Overhead')[0], 'GNU Terry Pratchett');;
    }
}
