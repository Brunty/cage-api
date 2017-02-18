<?php

namespace App\Api\Negotiator;

interface AcceptHeaderNegotiator
{

    /**
     * @param array $availableTypes
     *
     * @throws \App\Api\Negotiator\UnavailableContentTypeException
     * @return string
     */
    public function negotiate(array $availableTypes): string;
}
