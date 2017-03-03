<?php

namespace Tests\Integration\Infrastructure\Repository;

use App\Domain\Event\EventDispatcher;
use App\Domain\Event\RandomCageImageViewed;
use App\Domain\Model\Image;
use App\Domain\Repository\CageRepository;
use App\Infrastructure\Repository\EventDispatchingJsonFileCageRepository;
use PHPUnit\Framework\TestCase;

class EventDispatchingJsonFileCageRepositoryTest extends TestCase
{

    /**
     * @test
     */
    public function it_dispatches_an_event_for_a_single_random_cage_image()
    {
        /** @var \Prophecy\Prophecy\ObjectProphecy|CageRepository $repo */
        $repo = $this->prophesize(CageRepository::class);
        $returnImage = new Image('image');
        $repo->getRandomCageImage()->willReturn($returnImage);
        $dispatcher = $this->prophesize(EventDispatcher::class);
        $event = new RandomCageImageViewed($returnImage);
        $dispatcher->dispatch($event)->willReturn();

        $eventRepo = new EventDispatchingJsonFileCageRepository($repo->reveal(), $dispatcher->reveal());

        $image = $eventRepo->getRandomCageImage();

        self::assertInstanceOf(Image::class, $image);
        self::assertTrue(strlen($image) > 0);
        $repo->getRandomCageImage()->shouldBeCalled();
        $dispatcher->dispatch($event)->shouldBeCalled();
    }


    /**
     * @test
     * @dataProvider provider_for_it_passes_through_requests_for_multiple_cage_images_to_another_repository
     *
     * @param int $number
     */
    public function it_passes_through_requests_for_multiple_cage_images_to_another_repository(int $number)
    {
        /** @var \Prophecy\Prophecy\ObjectProphecy|CageRepository $repo */
        $repo = $this->prophesize(CageRepository::class);
        $returnImage = new Image('image');
        $repo->getRandomCageImages($number)->willReturn([$returnImage]);
        $dispatcher = $this->prophesize(EventDispatcher::class);

        $eventRepo = new EventDispatchingJsonFileCageRepository($repo->reveal(), $dispatcher->reveal());

        $images = $eventRepo->getRandomCageImages($number);

        self::assertCount(1, $images);

        foreach ($images as $image) {
            self::assertInstanceOf(Image::class, $image);
            self::assertTrue(strlen($image) > 0);
        }

        $repo->getRandomCageImages($number)->shouldBeCalled();
    }

    public function provider_for_it_passes_through_requests_for_multiple_cage_images_to_another_repository(): array
    {
        return [
            [1],
            [2],
            [3],
            [4],
            [5],
            [6],
            [7],
            [8],
            [9],
            [10]
        ];
    }
}
