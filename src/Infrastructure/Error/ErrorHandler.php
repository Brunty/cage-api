<?php

namespace App\Infrastructure\Error;

use Throwable;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
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
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger, bool $displayErrors = false, array $exceptions = [])
    {
        $this->logger = $logger;
        $this->exceptions = $exceptions;
        $this->displayErrors = $displayErrors;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        Throwable $exception
    ): ResponseInterface {

        $this->logger->critical($exception->getTraceAsString());

        foreach ($this->exceptions as $exceptionClass => $callback) {
            if ($exception instanceof $exceptionClass) {
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
