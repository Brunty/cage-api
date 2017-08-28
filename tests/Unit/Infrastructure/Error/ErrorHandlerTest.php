<?php

namespace Tests\Unit\Infrastructure\Error;

use App\Infrastructure\Error\ErrorHandler;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Log\LoggerInterface;

class ErrorHandlerTest extends TestCase
{

    /**
     * @test
     */
    public function it_returns_the_response_with_500_and_no_body_if_display_errors_is_disabled()
    {
        $logger = $this->prophesize(LoggerInterface::class);
        $request = $this->prophesize(ServerRequestInterface::class);
        $response = $this->prophesize(ResponseInterface::class);
        $response->withStatus(500)->willReturn($this->prophesize(ResponseInterface::class)->reveal());

        $exception = new \Exception;
        $handler = new ErrorHandler($logger->reveal(), false);

        /** @var ResponseInterface $response */
        $response = $handler($request->reveal(), $response->reveal(), $exception);

        self::assertNull($response->getBody());
    }

    /**
     * @test
     */
    public function it_returns_the_callback_of_an_exception_given_to_it_to_handle()
    {
        $logger = $this->prophesize(LoggerInterface::class);
        $request = $this->prophesize(ServerRequestInterface::class);
        $response = $this->prophesize(ResponseInterface::class);
        $response->withStatus(500)->willReturn($this->prophesize(ResponseInterface::class)->reveal());
        $callbackResponse = $this->prophesize(ResponseInterface::class);
        $callbackResponse->getBody()->willReturn('callbackresponse');

        $callback = function(ServerRequestInterface $request, ResponseInterface $response, \Exception $exception) use ($callbackResponse) {
            return $callbackResponse->reveal();
        };

        $exception = new \Exception;
        $handler = new ErrorHandler($logger->reveal(), true, [\Exception::class => $callback]);

        /** @var ResponseInterface $response */
        $response = $handler($request->reveal(), $response->reveal(), $exception);

        self::assertEquals('callbackresponse', $response->getBody());
    }

    /**
     * @test
     */
    public function it_returns_the_response_with_500_and_body_set_if_display_errors_is_enabled()
    {
        $logger = $this->prophesize(LoggerInterface::class);
        $request = $this->prophesize(ServerRequestInterface::class);
        $providedResponse = $this->prophesize(ResponseInterface::class);
        $statusResponse = $this->prophesize(ResponseInterface::class);
        $headerResponse = $this->prophesize(ResponseInterface::class);
        $bodyStream = $this->prophesize(StreamInterface::class);

        $providedResponse->withStatus(500)->willReturn($statusResponse->reveal());

        $statusResponse->withHeader('Content-Type', 'text/html')->willReturn($headerResponse->reveal());

        $headerResponse->getBody()->willReturn($bodyStream->reveal());

        $bodyStream->write(Argument::containingString('[Code: 9001]: Exception Message'))->shouldBeCalled();

        $handler = new ErrorHandler($logger->reveal(), true);

        /** @var ResponseInterface $handlerResponse */
        $handlerResponse = $handler($request->reveal(), $providedResponse->reveal(), new \Exception('Exception Message', 9001));
    }
}
