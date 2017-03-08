<?php
declare(strict_types = 1);

namespace App\Http\Responder\Page\Homepage;

use App\Presentation\Page\Homepage\Creator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class HomepageResponder implements Responder
{

    /**
     * @var Creator
     */
    private $creator;

    public function __construct(Creator $creator)
    {
        $this->creator = $creator;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {

        return $this->creator->createBody($response);
    }
}
