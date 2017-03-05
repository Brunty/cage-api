<?php

namespace Tests\Unit\Infrastructure\Error;

use App\Infrastructure\Error\ErrorHandler;
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
    public function it_returns_the_response_with_500_and_no_body_if_display_errors_is_disabled()
    {
        $request = $this->prophesize(ServerRequestInterface::class);
        $response = $this->prophesize(ResponseInterface::class);
        $response->withStatus(500)->willReturn($this->prophesize(ResponseInterface::class)->reveal());

        $exception = new \Exception;
        $handler = new ErrorHandler(false);

        /** @var ResponseInterface $response */
        $response = $handler($request->reveal(), $response->reveal(), $exception);

        self::assertNull($response->getBody());
    }
}
