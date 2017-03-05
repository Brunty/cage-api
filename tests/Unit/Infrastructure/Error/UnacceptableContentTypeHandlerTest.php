<?php

namespace Tests\Unit\Infrastructure\Error;

use App\Infrastructure\Error\ErrorHandler;
use App\Infrastructure\Error\UnacceptableContentTypeHandler;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;

class UnacceptableContentTypeHandlerTest extends TestCase
{

    /**
     * @test
     */
    public function it_sets_the_status_and_body_on_the_response()
    {
        $request = $this->prophesize(ServerRequestInterface::class);
        $providedResponse = $this->prophesize(ResponseInterface::class);
        $statusResponse = $this->prophesize(ResponseInterface::class);
        $headerResponse = $this->prophesize(ResponseInterface::class);
        $bodyStream = $this->prophesize(StreamInterface::class);

        $providedResponse->withStatus(406)->willReturn($statusResponse->reveal());
        $statusResponse->withHeader('Content-Type', 'application/json')->willReturn($headerResponse->reveal());
        $headerResponse->getBody()->willReturn($bodyStream->reveal());

        $bodyStream->write('{"error":{"status":406,"message":"You have requested a content type that we do not currently support","acceptable_types":["foo\/bar"]}}')->shouldBeCalled();

        $headerResponse->withBody($bodyStream->reveal())->willReturn($this->prophesize(ResponseInterface::class)->reveal());

        $exception = new \Exception;
        $handler = new UnacceptableContentTypeHandler(['foo/bar']);

        /** @var ResponseInterface $response */
        $response = $handler($request->reveal(), $providedResponse->reveal(), $exception);
    }
}
