<?php

namespace Tests\Unit\Http\Responder\RandomCage\MultipleImage;

use App\Domain\Collection\ImageCollection;
use App\Domain\Model\Image;
use App\Http\Negotiator\AcceptHeaderNegotiator;
use App\Http\Negotiator\UnavailableContentTypeException;
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
        $images = new ImageCollection([new Image('imagesrc')]);
        $contentType = 'application/json';
        $request = $this->prophesize(ServerRequestInterface::class);
        $response = $this->prophesize(ResponseInterface::class);
        $availableTypes = [];

        $negotiator = $this->prophesize(AcceptHeaderNegotiator::class);
        $negotiator->negotiate($availableTypes)->willReturn($contentType);

        $bodyStream = $this->prophesize(StreamInterface::class);
        $response->getBody()->willReturn($bodyStream->reveal());

        $content = '';
        $creator = $this->prophesize(Creator::class);
        $creator->createBody($contentType, $images)->willReturn($content);

        $bodyStream->write($content)->shouldBeCalled();

        $response->withHeader('Content-Type', $contentType)->willReturn($response);
        $response->withBody($bodyStream)->willReturn($response);

        $responder = new MultipleImageResponder($creator->reveal(), $negotiator->reveal(), $availableTypes);

        $responder($request->reveal(), $response->reveal(), $images);
    }

    /** @test */
    public function it_sets_the_header_if_no_acceptable_content_type_is_found()
    {
        $images = new ImageCollection([new Image('imagesrc')]);
        $creator = $this->prophesize(Creator::class);
        $availableTypes = [];
        $negotiator = $this->prophesize(AcceptHeaderNegotiator::class);
        $negotiator->negotiate($availableTypes)->willThrow(UnavailableContentTypeException::class);

        $request = $this->prophesize(ServerRequestInterface::class);
        $response = $this->prophesize(ResponseInterface::class);
        $response->withStatus(StatusCode::NOT_ACCEPTABLE)->willReturn($response);

        $responder = new MultipleImageResponder($creator->reveal(), $negotiator->reveal(), $availableTypes);

        $responder($request->reveal(), $response->reveal(), $images);

        $response->withStatus(StatusCode::NOT_ACCEPTABLE)->shouldHaveBeenCalled();
    }


    /** @test */
    public function it_returns_a_bad_request_if_an_exception_was_set()
    {
        $images = new ImageCollection([new Image('imagesrc')]);
        $contentType = 'application/json';
        $creator = $this->prophesize(Creator::class);
        $availableTypes = [];
        $negotiator = $this->prophesize(AcceptHeaderNegotiator::class);
        $negotiator->negotiate($availableTypes)->willReturn($contentType);

        $request = $this->prophesize(ServerRequestInterface::class);
        $response = $this->prophesize(ResponseInterface::class);
        $response->withStatus(StatusCode::BAD_REQUEST)->willReturn($response);

        $responder = new MultipleImageResponder($creator->reveal(), $negotiator->reveal(), $availableTypes);
        $responder->setException(new \OutOfRangeException);

        $responder($request->reveal(), $response->reveal(), $images);

        $response->withStatus(StatusCode::BAD_REQUEST)->shouldHaveBeenCalled();
    }
}
