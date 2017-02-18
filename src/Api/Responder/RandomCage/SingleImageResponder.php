<?php

namespace App\Api\Responder\RandomCage;

use App\Domain\Model\Image;
use App\Infrastructure\Negotiator\AcceptHeaderNegotiator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SingleImageResponder
{

    /**
     * @var AcceptHeaderNegotiator
     */
    private $negotiator;

    public function __construct(AcceptHeaderNegotiator $negotiator)
    {
        $this->negotiator = $negotiator;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, Image $image): ResponseInterface
    {
        $body = $response->getBody();
        $body->write(json_encode(['image' => (string)$image]));
        $response = $response->withHeader('Content-Type', 'application/json');
        $response = $response->withBody($body);
        return $response;
    }
}
