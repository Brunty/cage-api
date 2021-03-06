<?php

namespace Tests\Integration\Infrastructure\Repository;

use App\Domain\Collection\ImageCollection;
use App\Domain\Event\EventDispatcher;
use App\Domain\Event\CageImageAccessed;
use App\Domain\Entity\Image;
use App\Domain\Repository\CageRepository;
use App\Domain\Value\Url;
use App\Infrastructure\Repository\EventDispatchingCageRepository;
use PHPUnit\Framework\TestCase;

class EventDispatchingCageRepositoryTest extends TestCase
{

    /**
     * @test
     */
    public function it_dispatches_an_event_for_a_single_random_cage_image()
    {
        /** @var \Prophecy\Prophecy\ObjectProphecy|CageRepository $repo */
        $repo = $this->prophesize(CageRepository::class);
        $returnImage = new Image(new Url('http://site.tld/image.png'));
        $repo->getRandomCageImage()->willReturn($returnImage);
        $dispatcher = $this->prophesize(EventDispatcher::class);
        $event = new CageImageAccessed($returnImage);
        $dispatcher->dispatch($event)->willReturn();

        $eventRepo = new EventDispatchingCageRepository($repo->reveal(), $dispatcher->reveal());

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
        $returnImage = new Image(new Url('http://site.tld/image.png'));
        $repo->getRandomCageImages($number)->willReturn(new ImageCollection([$returnImage]));
        $dispatcher = $this->prophesize(EventDispatcher::class);

        $eventRepo = new EventDispatchingCageRepository($repo->reveal(), $dispatcher->reveal());

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
