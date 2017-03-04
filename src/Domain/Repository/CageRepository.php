<?php

namespace App\Domain\Repository;

use App\Domain\Collection\ImageCollection;
use App\Domain\Model\Image;

interface CageRepository
{

    CONST MAX_BOMB_CAGES = 10;

    public function getRandomCageImage(): Image;

    public function getRandomCageImages(int $count = 5): ImageCollection;
}
