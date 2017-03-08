<?php

namespace App\Domain\Event;

use App\Domain\Model\Image;
use League\Event\AbstractEvent as Event;

final class CageImageAccessed extends Event
{

    /**
     * @var Image
     */
    private $image;

    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    public function getImage(): Image
    {
        return $this->image;
    }
}
