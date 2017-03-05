<?php
declare(strict_types=1);

namespace App\Http\Responder\RandomCage\MultipleImage;

use App\Http\Negotiator\UnacceptableContentTypeException;
use App\Presentation\RandomCage\MultipleImage\Creator;
use App\Http\Negotiator\AcceptHeaderNegotiator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Teapot\StatusCode;
use App\Domain\Collection\ImageCollection;

final class MultipleImageResponder implements Responder
{

    /**
     * @var Creator
     */
    private $creator;

    /**
     * @var \Throwable
     */
    private $exception;

    public function __construct(Creator $creator)
    {
        $this->creator = $creator;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        ImageCollection $images
    ): ResponseInterface {

        if ($this->exception !== null) {
            return $response->withStatus(StatusCode::BAD_REQUEST);
        }

        $body = $response->getBody();
        $body->write($this->creator->createBody($response->getHeader('Content-Type')[0], $images));

        /** @var ResponseInterface $response */
        $response = $response->withBody($body);

        return $response;
    }

    public function setException(\Throwable $exception)
    {
        $this->exception = $exception;
    }
}
