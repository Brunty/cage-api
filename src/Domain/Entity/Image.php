<?php

namespace App\Domain\Entity;

use App\Domain\Value\Url;

final class Image
{

    /**
     * @var Url
     */
    private $url;

    public function __construct(Url $url)
    {
        $this->url = $url;
    }

    public function __toString(): string
    {
        return (string) $this->url;
    }
}
