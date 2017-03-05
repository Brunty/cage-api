<?php

namespace App\Infrastructure\Error;

use App\Http\Negotiator\UnacceptableContentTypeException;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Teapot\StatusCode;

class UnacceptableContentTypeHandler
{

    /**
     * @var array
     */
    private $contentTypes;

    public function __construct(array $contentTypes)
    {
        $this->contentTypes = $contentTypes;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        Exception $exception
    ): ResponseInterface {
        $response = $response->withStatus(StatusCode::NOT_ACCEPTABLE);
        $response = $response->withHeader('Content-Type', 'application/json');

        $body = $response->getBody();
        $body->write(
            json_encode(
                [
                    'error' => [
                        'status'           => StatusCode::NOT_ACCEPTABLE,
                        'message'          => 'You have requested a content type that we do not currently support',
                        'acceptable_types' => $this->contentTypes
                    ]
                ]
            )
        );

        /** @var ResponseInterface $response */
        return $response->withBody($body);
    }
}
