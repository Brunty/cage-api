<?php

namespace App\Presentation\RandomCage\MultipleImage;

use App\Domain\Collection\ImageCollection;
use App\Domain\Model\Image;

interface Creator
{

    public function createBody(string $type, ImageCollection $images): string;
}
