<?php

namespace Tests\Unit\Http\Actions\RandomCage;

use App\Domain\Collection\ImageCollection;
use App\Domain\Model\Image;
use App\Domain\Repository\CageRepository;
use App\Http\Action\RandomCage\MultipleImageAction;
use App\Http\Responder\RandomCage\MultipleImage\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MultipleImageActionTest extends \PHPUnit\Framework\TestCase
{

    /** @test */
    public function it_invokes_the_responder_correctly()
    {
        $images = new ImageCollection([new Image('imageurl'), new Image('2ndimageurl')]);
        $repo = $this->prophesize(CageRepository::class);
        $repo->getRandomCageImages(2)->willReturn($images);

        $request = $this->prophesize(ServerRequestInterface::class);
        $response = $this->prophesize(ResponseInterface::class);

        $responder = $this->prophesize(Responder::class);
        $responder->__invoke($request->reveal(), $response->reveal(), $images)->willReturn($response->reveal());

        $action = new MultipleImageAction($repo->reveal(), $responder->reveal());

        $action($request->reveal(), $response->reveal(), ['number' => 2]);

        $responder->__invoke($request, $response, $images)->shouldHaveBeenCalled();
    }

    /** @test */
    public function it_passes_the_exception_to_the_responder_if_too_many_images_are_requested()
    {
        $images = new ImageCollection([]);
        $repo = $this->prophesize(CageRepository::class);
        $exception = new \OutOfRangeException;
        $repo->getRandomCageImages(2)->willThrow($exception);

        $request = $this->prophesize(ServerRequestInterface::class);
        $response = $this->prophesize(ResponseInterface::class);

        $responder = $this->prophesize(Responder::class);
        $responder->__invoke($request->reveal(), $response->reveal(), $images)->willReturn($response->reveal());
        $responder->setException($exception)->willReturn(null);

        $action = new MultipleImageAction($repo->reveal(), $responder->reveal());

        $action($request->reveal(), $response->reveal(), ['number' => 2]);

        $responder->__invoke($request, $response, $images)->shouldHaveBeenCalled();
    }
}
