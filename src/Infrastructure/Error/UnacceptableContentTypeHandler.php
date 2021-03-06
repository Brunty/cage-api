<?php

namespace App\Infrastructure\Error;

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
    ) {
        $response = $response->withStatus(StatusCode::NOT_ACCEPTABLE);
        /** @var ResponseInterface $response */
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

        return $response->withBody($body);
    }
}
