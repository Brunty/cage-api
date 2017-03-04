<?php
declare(strict_types=1);

namespace App\Http\Negotiator;

use Aura\Accept\Accept;

final class AuraAcceptHeaderNegotiator implements AcceptHeaderNegotiator
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
        $availableTypes = $this->accept->negotiateMedia($availableTypes);

        if ($availableTypes === false) {
            throw new UnavailableContentTypeException;
        }

        return $availableTypes->getValue();
    }
}
