<?php

namespace App\Presentation\RandomCage\SingleImage;

use App\Domain\Entity\Image;

interface Creator
{

    public function createBody(string $type, Image $image): string;
}
