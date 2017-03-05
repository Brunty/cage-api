<?php

namespace App\Infrastructure\Error;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Teapot\StatusCode;

class ErrorHandler
{

    /**
     * @var array
     */
    private $exceptions;

    /**
     * @var bool
     */
    private $displayErrors;

    public function __construct(bool $displayErrors = false, array $exceptions = [])
    {
        $this->exceptions = $exceptions;
        $this->displayErrors = $displayErrors;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, Exception $exception): ResponseInterface
    {
        foreach($this->exceptions as $exceptionClass => $callback) {
            if($exception instanceof $exceptionClass) {
                return $callback($request, $response, $exception);
            }
        }

        $response = $response->withStatus(StatusCode::INTERNAL_SERVER_ERROR);

        if ($this->displayErrors === false) {
            return $response;
        }

        /** @var ResponseInterface $response */
        $response = $response->withHeader('Content-Type', 'text/html');

        $body = $response->getBody();

        $bodyContent = <<<EXCEPTION
<pre>{$exception->getFile()}:{$exception->getLine()}</pre>
<pre>[Code: {$exception->getCode()}]: {$exception->getMessage()}</pre>
<pre>{$exception->getTraceAsString()}</pre>
EXCEPTION;

        $body->write($bodyContent);

        return $response;
    }
}
