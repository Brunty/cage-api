<?php declare(strict_types=1);

namespace App\Domain\Value;

class Url
{
    /**
     * @var string
     */
    private $url;

    public function __construct(string $url)
    {
        if ( ! filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException("Not a valid URL: {$url}");
        }

        $this->url = $url;
    }

    public function __toString(): string
    {
        return $this->url;
    }
}
