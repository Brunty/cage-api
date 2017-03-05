<?php

namespace Tests\Unit\Http\Responder\RandomCage\SingleImage;

use App\Domain\Model\Image;
use App\Http\Negotiator\AcceptHeaderNegotiator;
use App\Http\Negotiator\UnacceptableContentTypeException;
use App\Http\Responder\RandomCage\SingleImage\SingleImageResponder;
use App\Presentation\RandomCage\SingleImage\Creator;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Teapot\StatusCode;

class SingleImageResponderTest extends TestCase
{

    /** @test */
    public function it_sets_the_content_type_and_body_if_content_type_is_found()
    {
        $image = new Image('imagesrc');
        $contentType = 'application/json';
        $request = $this->prophesize(ServerRequestInterface::class);
        $response = $this->prophesize(ResponseInterface::class);

        $bodyStream = $this->prophesize(StreamInterface::class);
        $response->getHeader('Content-Type')->willReturn([$contentType]);
        $response->getBody()->willReturn($bodyStream->reveal());

        $content = '';
        $creator = $this->prophesize(Creator::class);
        $creator->createBody($contentType, $image)->willReturn($content);

        $bodyStream->write($content)->shouldBeCalled();
        $response->withBody($bodyStream)->willReturn($response);

        $responder = new SingleImageResponder($creator->reveal());

        $responder($request->reveal(), $response->reveal(), $image);
    }
}
