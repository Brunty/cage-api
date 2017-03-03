<?php

namespace Tests\Unit\Http\Actions\Page;

use App\Http\Action\Page\HomepageAction;
use App\Http\Responder\Page\Homepage\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomepageActionTest extends \PHPUnit\Framework\TestCase
{

    /** @test */
    public function it_invokes_the_responder_correctly()
    {
        $request = $this->prophesize(ServerRequestInterface::class);
        $response = $this->prophesize(ResponseInterface::class);

        $responder = $this->prophesize(Responder::class);
        $responder->__invoke($request->reveal(), $response->reveal())->willReturn($response->reveal());

        $action = new HomepageAction($responder->reveal());

        $action($request->reveal(), $response->reveal());

        $responder->__invoke($request, $response)->shouldHaveBeenCalled();
    }
}
