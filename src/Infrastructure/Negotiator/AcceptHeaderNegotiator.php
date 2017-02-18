<?php

namespace App\Infrastructure\Negotiator;

interface AcceptHeaderNegotiator
{
    public function negotiate(array $availableTypes): string;
}
