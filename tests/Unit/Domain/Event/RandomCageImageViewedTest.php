<?php

namespace Tests\Unit\Domain\Event;

use App\Domain\Event\CageImageAccessed;
use App\Domain\Model\Image;
use PHPUnit\Framework\TestCase;

class RandomCageImageViewedTest extends TestCase
{
    /**
     * @test
     */
    public function it_stores_the_image_in_the_event()
    {
        $image = new Image('imagesrc');
        $event = new CageImageAccessed($image);

        self::assertEquals($image, $event->getImage());
    }
}
