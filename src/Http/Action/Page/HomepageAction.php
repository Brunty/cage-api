<?php
declare(strict_types=1);

namespace App\Http\Action\Page;

use App\Http\Responder\Page\Homepage\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomepageAction
{


    /**
     * @var Responder
     */
    private $responder;

    public function __construct(Responder $responder)
    {
        $this->responder = $responder;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $responder = $this->responder;
        
        return $responder($request, $response);
    }
}
