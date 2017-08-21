<?php

namespace Tests\Unit\Http\Responder\Page\Homepage;

use App\Domain\Entity\Image;
use App\Http\Negotiator\AcceptHeaderNegotiator;
use App\Http\Negotiator\UnacceptableContentTypeException;
use App\Http\Responder\Page\Homepage\HomepageResponder;
use App\Presentation\Page\Homepage\Creator;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Teapot\StatusCode;

class HomepageResponderTest extends TestCase
{

    /** @test */
    public function it_sets_the_content_type_and_body_if_content_type_is_found()
    {
        $request = $this->prophesize(ServerRequestInterface::class);
        $response = $this->prophesize(ResponseInterface::class);

        $creator = $this->prophesize(Creator::class);
        $creator->createBody($response->reveal())->willReturn($response->reveal());

        $responder = new HomepageResponder($creator->reveal());

        $responder($request->reveal(), $response->reveal());

        $creator->createBody($response->reveal())->shouldHaveBeenCalled();
    }
}
