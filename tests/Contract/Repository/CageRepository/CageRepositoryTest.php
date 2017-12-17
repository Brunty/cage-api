<?php

namespace Tests\Contract\Repository\CageRepository;

use App\Domain\Entity\Image;
use App\Domain\Repository\CageRepository;
use PHPUnit\Framework\TestCase;

abstract class CageRepositoryTest extends TestCase
{

    /**
     * @var CageRepository
     */
    protected $repository;

    /** @test */
    public function it_gets_a_random_cage_image()
    {
        $image = $this->repository->getRandomCageImage();

        self::assertInstanceOf(Image::class, $image);
        self::assertTrue(strlen($image) > 0);
    }

    /** @test */
    public function it_gets_multiple_random_cage_images()
    {
        $images = $this->repository->getRandomCageImages(5);

        self::assertCount(5, $images);

        foreach ($images as $image) {
            self::assertInstanceOf(Image::class, $image);
            self::assertTrue(strlen($image) > 0);
        }
    }
}
