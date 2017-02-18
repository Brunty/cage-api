<?php

namespace App\Http\Negotiator;

interface AcceptHeaderNegotiator
{

    /**
     * @param array $availableTypes
     *
     * @throws \App\Http\Negotiator\UnavailableContentTypeException
     * @return string
     */
    public function negotiate(array $availableTypes): string;
}
