<?php

namespace Tests\Unit\Infrastructure\Event\Listener;

use App\Domain\Event\RandomCageImageViewed;
use App\Domain\Model\Image;
use App\Infrastructure\Event\Listener\ImageViewedListener;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class ImageViewedListenerTest extends TestCase
{

    /**
     * @test
     */
    public function it_is_a_listener()
    {
        $logger = $this->prophesize(LoggerInterface::class);
        $listener = new ImageViewedListener($logger->reveal());

        self::assertTrue($listener->isListener($listener));
    }

    /**
     * @test
     */
    public function it_handles_an_event()
    {
        $logger = $this->prophesize(LoggerInterface::class);
        $image = new Image('imageurl');
        $logger->info('Image viewed: imageurl')->willReturn();
        $listener = new ImageViewedListener($logger->reveal());
        $event = new RandomCageImageViewed($image);

        $listener->handle($event);

        $logger->info('Image viewed: imageurl')->shouldHaveBeenCalled();


    }
}
