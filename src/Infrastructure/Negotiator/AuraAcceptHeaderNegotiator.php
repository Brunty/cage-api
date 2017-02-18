<?php

namespace App\Infrastructure\Negotiator;

use Aura\Accept\Accept;

class AuraAcceptHeaderNegotiator implements AcceptHeaderNegotiator
{

    /**
     * @var Accept
     */
    private $accept;

    public function __construct(Accept $accept)
    {
        $this->accept = $accept;
    }

    public function negotiate(array $availableTypes): string
    {
        return $this->accept->negotiateMedia($availableTypes)->getType();
    }
}
