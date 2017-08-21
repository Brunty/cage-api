<?php

namespace Tests\Unit\Http\Actions\RandomCage;

use App\Domain\Entity\Image;
use App\Domain\Repository\CageRepository;
use App\Domain\Value\Url;
use App\Http\Action\RandomCage\SingleImageAction;
use App\Http\Responder\RandomCage\SingleImage\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SingleImageActionTest extends \PHPUnit\Framework\TestCase
{

    /** @test */
    public function it_invokes_the_responder_correctly()
    {
        $image = new Image(new Url('http://site.tld/imageurl.png'));
        $repo = $this->prophesize(CageRepository::class);
        $repo->getRandomCageImage()->willReturn($image);

        $request = $this->prophesize(ServerRequestInterface::class);
        $response = $this->prophesize(ResponseInterface::class);

        $responder = $this->prophesize(Responder::class);
        $responder->__invoke($request->reveal(), $response->reveal(), $image)->willReturn($response->reveal());

        $action = new SingleImageAction($repo->reveal(), $responder->reveal());

        $action($request->reveal(), $response->reveal());

        $responder->__invoke($request, $response, $image)->shouldHaveBeenCalled();
    }
}
