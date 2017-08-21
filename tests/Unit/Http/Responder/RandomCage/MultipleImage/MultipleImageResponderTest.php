<?php

namespace Tests\Unit\Http\Responder\RandomCage\MultipleImage;

use App\Domain\Collection\ImageCollection;
use App\Domain\Entity\Image;
use App\Domain\Value\Url;
use App\Http\Responder\RandomCage\MultipleImage\MultipleImageResponder;
use App\Presentation\RandomCage\MultipleImage\Creator;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Teapot\StatusCode;

class MultipleImageResponderTest extends TestCase
{

    /** @test */
    public function it_sets_the_content_type_and_body_if_content_type_is_found()
    {
        $images = new ImageCollection([new Image(new Url('http://site.com/image.png'))]);
        $contentType = 'application/json';
        $request = $this->prophesize(ServerRequestInterface::class);
        $response = $this->prophesize(ResponseInterface::class);

        $bodyStream = $this->prophesize(StreamInterface::class);
        $response->getHeader('Content-Type')->willReturn([$contentType]);
        $response->getBody()->willReturn($bodyStream->reveal());

        $content = '';
        $creator = $this->prophesize(Creator::class);
        $creator->createBody($contentType, $images)->willReturn($content);

        $bodyStream->write($content)->shouldBeCalled();
        $response->withBody($bodyStream)->willReturn($response);

        $responder = new MultipleImageResponder($creator->reveal());

        $responder($request->reveal(), $response->reveal(), $images);
    }

    /** @test */
    public function it_returns_a_bad_request_if_an_exception_was_set()
    {
        $images = new ImageCollection([new Image(new Url('http://site.com/image.png'))]);
        $creator = $this->prophesize(Creator::class);

        $request = $this->prophesize(ServerRequestInterface::class);
        $response = $this->prophesize(ResponseInterface::class);
        $response->withStatus(StatusCode::BAD_REQUEST)->willReturn($response);

        $responder = new MultipleImageResponder($creator->reveal());
        $responder->setException(new \OutOfRangeException);

        $responder($request->reveal(), $response->reveal(), $images);

        $response->withStatus(StatusCode::BAD_REQUEST)->shouldHaveBeenCalled();
    }
}
