<?php
declare(strict_types = 1);

namespace App\Http\Responder\RandomCage\SingleImage;

use App\Presentation\RandomCage\SingleImage\Creator;
use App\Domain\Entity\Image;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class SingleImageResponder implements Responder
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
        ResponseInterface $response,
        Image $image
    ): ResponseInterface {

        $body = $response->getBody();
        $body->write($this->creator->createBody($response->getHeader('Content-Type')[0], $image));

        /** @var ResponseInterface $response */
        $response = $response->withBody($body);

        return $response;
    }
}
