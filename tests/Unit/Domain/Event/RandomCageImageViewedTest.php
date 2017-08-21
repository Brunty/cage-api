<?php

namespace Tests\Unit\Domain\Event;

use App\Domain\Event\CageImageAccessed;
use App\Domain\Entity\Image;
use App\Domain\Value\Url;
use PHPUnit\Framework\TestCase;

class RandomCageImageViewedTest extends TestCase
{
    /**
     * @test
     */
    public function it_stores_the_image_in_the_event()
    {
        $image = new Image(new Url('http://site.tld/thisisanimagesourceurl.png'));
        $event = new CageImageAccessed($image);

        self::assertEquals($image, $event->getImage());
    }
}
