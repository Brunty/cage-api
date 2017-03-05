<?php

namespace Tests\Unit\Http\Middleware;

use App\Http\Middleware\AcceptHeaderMiddleware;
use App\Http\Negotiator\AcceptHeaderNegotiator;
use App\Http\Negotiator\UnacceptableContentTypeException;
use PHPUnit\Framework\TestCase;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Stream;
use Slim\Http\Uri;

class AcceptHeaderMiddlewareTest extends TestCase
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
        $negotiator = $this->prophesize(AcceptHeaderNegotiator::class);
        $negotiator->negotiate([])->willReturn('application/json');
        $middleware = new AcceptHeaderMiddleware($negotiator->reveal(), []);

        $middlewareResponse = $middleware(
            $request,
            $response,
            function ($request, $response) {
                return $response;
            }
        );

        self::assertEquals('application/json', $middlewareResponse->getHeader('Content-Type')[0]);
    }


    /**
     * @test
     */
    public function it_bubbles_up_an_exception()
    {
        $this->expectException(UnacceptableContentTypeException::class);
        $request = new Request(
            'GET',
            new Uri('', ''),
            new Headers([]),
            [],
            [],
            new Stream(stream_context_create([]))
        );
        $response = new Response;
        $negotiator = $this->prophesize(AcceptHeaderNegotiator::class);
        $negotiator->negotiate([])->willThrow(UnacceptableContentTypeException::class);
        $middleware = new AcceptHeaderMiddleware($negotiator->reveal(), []);

        $middlewareResponse = $middleware(
            $request,
            $response,
            function ($request, $response) {
                return $response;
            }
        );
    }
}
