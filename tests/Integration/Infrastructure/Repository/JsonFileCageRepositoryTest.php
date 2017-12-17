<?php

namespace Tests\Integration\Infrastructure\Repository;

use App\Domain\Entity\Image;
use App\Infrastructure\Repository\JsonFileCageRepository;
use PHPUnit\Framework\TestCase;

class JsonFileCageRepositoryTest extends TestCase
{

    /**
     * @var JsonFileCageRepository
     */
    private $repo;

    protected function setUp()
    {
        $filePath = __DIR__ . '/../../../Resources/cages.json';

        $this->repo = new JsonFileCageRepository($filePath);
    }

    /**
     * @test
     */
    public function it_gets_a_single_random_cage_image()
    {
        $image = $this->repo->getRandomCageImage();

        self::assertInstanceOf(Image::class, $image);
        self::assertTrue(strlen($image) > 0);
    }

    /**
     * @test
     * @dataProvider provider_for_it_gets_multiple_random_cage_images
     *
     * @param int $number
     */
    public function it_gets_multiple_random_cage_images(int $number)
    {
        $images = $this->repo->getRandomCageImages($number);

        self::assertCount($number, $images);

        foreach ($images as $image) {
            self::assertInstanceOf(Image::class, $image);
            self::assertTrue(strlen($image) > 0);
        }
    }

    public function provider_for_it_gets_multiple_random_cage_images(): array
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

    /**
     * @test
     * @dataProvider provider_for_it_throws_an_exception_if_too_many_cages_are_requested
     *
     * @param int $number
     */
    public function it_throws_an_exception_if_too_many_cages_are_requested(int $number)
    {
        $this->expectException(\OutOfRangeException::class);

        $images = $this->repo->getRandomCageImages($number);
    }

    public function provider_for_it_throws_an_exception_if_too_many_cages_are_requested(): array
    {
        return [
            [11],
            [100]
        ];
    }
}
