<?php

namespace Tests\Double\Repository;

use App\Domain\Collection\ImageCollection;
use App\Domain\Entity\Image;
use App\Domain\Repository\CageRepository;
use App\Domain\Value\Url;

class InMemoryCageRepository implements CageRepository
{

    private $images = [];

    public function getRandomCageImage(): Image
    {
        $this->loadImages();

        return $this->images[0];
    }

    public function getRandomCageImages(int $count = 5): ImageCollection
    {
        $this->loadImages();

        return new ImageCollection(array_slice($this->images, 0, $count));
    }

    private function loadImages()
    {
        $this->images = [
            new Image(new Url('http://site.com/image-url-0')),
            new Image(new Url('http://site.com/image-url-1')),
            new Image(new Url('http://site.com/image-url-2')),
            new Image(new Url('http://site.com/image-url-3')),
            new Image(new Url('http://site.com/image-url-4')),
            new Image(new Url('http://site.com/image-url-5')),
            new Image(new Url('http://site.com/image-url-6')),
            new Image(new Url('http://site.com/image-url-7')),
            new Image(new Url('http://site.com/image-url-8')),
            new Image(new Url('http://site.com/image-url-9')),
        ];

        shuffle($this->images);
    }
}
