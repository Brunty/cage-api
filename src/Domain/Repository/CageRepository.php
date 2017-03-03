<?php

namespace App\Domain\Repository;

use App\Domain\Model\Image;

interface CageRepository
{

    public function getRandomCageImage(): Image;

    public function getRandomCageImages(int $count = 5): array;
}
