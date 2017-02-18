<?php

namespace App\Domain\Model;

final class Quote
{

    /**
     * @var string
     */
    private $url;

    public function __construct(string $text)
    {
        $this->url = $text;
    }

    function __toString(): string
    {
        return $this->url;
    }
}
