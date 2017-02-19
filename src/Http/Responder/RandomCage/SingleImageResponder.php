<?php

namespace App\Http\Responder\RandomCage;

use App\Http\Negotiator\UnavailableContentTypeException;
use App\Presentation\RandomCage\SingleImage\Creator;
use App\Domain\Model\Image;
use App\Http\Negotiator\AcceptHeaderNegotiator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Teapot\StatusCode;

class SingleImageResponder
{

    /**
     * @var AcceptHeaderNegotiator
     */
    private $negotiator;
    /**
     * @var array
     */
    private $availableTypes;
    /**
     * @var Creator
     */
    private $creator;

    public function __construct(Creator $creator, AcceptHeaderNegotiator $negotiator, array $availableTypes = [])
    {
        $this->negotiator = $negotiator;
        $this->availableTypes = $availableTypes;
        $this->creator = $creator;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        Image $image
    ): ResponseInterface {
        try {
            $type = $this->negotiator->negotiate($this->availableTypes);
        } catch (UnavailableContentTypeException $exception) {
            return $response->withStatus(StatusCode::NOT_ACCEPTABLE);
        }

        $body = $response->getBody();
        $body->write($this->creator->createBody($type, $image));

        /** @var ResponseInterface $response */
        $response = $response->withHeader('Content-Type', $type);
        $response = $response->withBody($body);

        return $response;
    }
}
