<?php

namespace App\Api\Responder\RandomCage;

use App\Api\Negotiator\UnavailableContentTypeException;
use App\Domain\Model\Image;
use App\Api\Negotiator\AcceptHeaderNegotiator;
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

    public function __construct(AcceptHeaderNegotiator $negotiator, array $availableTypes = [])
    {
        $this->negotiator = $negotiator;
        $this->availableTypes = $availableTypes;
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
        $body->write($this->createBodyContent($type, $image));

        /** @var ResponseInterface $response */
        $response = $response->withHeader('Content-Type', $type);
        $response = $response->withBody($body);

        return $response;
    }

    /**
     * @param string $type
     * @param Image  $image
     *
     * @return string
     */
    private function createBodyContent(string $type, Image $image): string
    {
        switch ($type) {
            case 'application/json':
            default:
                return json_encode(['image' => (string) $image]);
        }
    }
}
