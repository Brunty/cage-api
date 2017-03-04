<?php
declare(strict_types=1);

namespace App\Http\Responder\RandomCage\MultipleImage;

use App\Http\Negotiator\UnavailableContentTypeException;
use App\Presentation\RandomCage\MultipleImage\Creator;
use App\Http\Negotiator\AcceptHeaderNegotiator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Teapot\StatusCode;
use App\Domain\Collection\ImageCollection;

final class MultipleImageResponder implements Responder
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

    /**
     * @var \Throwable
     */
    private $exception;

    public function __construct(Creator $creator, AcceptHeaderNegotiator $negotiator, array $availableTypes = [])
    {
        $this->negotiator = $negotiator;
        $this->availableTypes = $availableTypes;
        $this->creator = $creator;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        ImageCollection $images
    ): ResponseInterface {
        try {
            $type = $this->negotiator->negotiate($this->availableTypes);
        } catch (UnavailableContentTypeException $exception) {
            return $response->withStatus(StatusCode::NOT_ACCEPTABLE);
        }

        if ($this->exception !== null) {
            return $response->withStatus(StatusCode::BAD_REQUEST);
        }

        $body = $response->getBody();
        $body->write($this->creator->createBody($type, $images));

        /** @var ResponseInterface $response */
        $response = $response->withHeader('Content-Type', $type);
        $response = $response->withBody($body);

        return $response;
    }

    public function setException(\Throwable $exception)
    {
        $this->exception = $exception;
    }
}
