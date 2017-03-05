<?php

namespace App\Domain\Model;

class Image
{

    /**
     * @var string
     */
    private $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function __toString(): string
    {
        return $this->url;
    }
}
