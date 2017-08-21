<?php
declare(strict_types = 1);

namespace App\Infrastructure\Repository;

use App\Domain\Collection\ImageCollection;
use App\Domain\Entity\Image;
use App\Domain\Repository\CageRepository;
use App\Domain\Value\Url;
use OutOfRangeException;

final class JsonFileCageRepository implements CageRepository
{

    /**
     * @var array
     */
    private $cages = [];

    /**
     * @var string
     */
    private $storageFilePath;

    public function __construct(string $storageFilePath)
    {
        $this->storageFilePath = $storageFilePath;
    }

    public function getRandomCageImage(): Image
    {
        return $this->getRandomCageImages(1)[0];
    }

    public function getRandomCageImages(int $count = 5): ImageCollection
    {
        /* move this elsewhere as it's basically validation? Don't like it in repo, oh well... */
        if ($count > self::MAX_BOMB_CAGES) {
            throw new OutOfRangeException(
                sprintf(
                    "YOU WANT %d?! THAT'S TOO MANY CAGES. I CAN'T HANDLE THAT! (Best I can do is %d...)",
                    $count,
                    self::MAX_BOMB_CAGES
                )
            );
        }

        // ALL THE CAGES!
        $cages = $this->getAllCageImages();

        shuffle($cages);

        $collection = new ImageCollection($cages);

        return $collection->slice(0, $count)->map(
            function ($string) {
                return new Image(new Url($string));
            }
        );
    }

    private function getAllCageImages(): array
    {
        if ( ! $this->cages) {
            $this->loadCageImages();
        }

        return $this->cages;
    }

    private function loadCageImages()
    {
        $fileContents = json_decode(file_get_contents($this->storageFilePath), true);

        $this->cages = $fileContents['cages'];
    }
}
