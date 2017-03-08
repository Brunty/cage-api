<?php
declare(strict_types = 1);

namespace App\Http\Middleware;

use App\Http\Negotiator\AcceptHeaderNegotiator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AcceptHeaderMiddleware
{

    /**
     * @var AcceptHeaderNegotiator
     */
    private $negotiator;

    /**
     * @var array
     */
    private $availableTypes;

    public function __construct(AcceptHeaderNegotiator $negotiator, array $availableTypes)
    {
        $this->negotiator = $negotiator;
        $this->availableTypes = $availableTypes;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface {
        /** @var ResponseInterface $response */
        $response = $response->withHeader('Content-Type', $this->negotiator->negotiate($this->availableTypes));

        return $next($request, $response);
    }
}
