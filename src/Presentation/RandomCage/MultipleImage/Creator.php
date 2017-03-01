<?php

namespace App\Presentation\RandomCage\MultipleImage;

use App\Domain\Model\Image;

interface Creator
{

    public function createBody(string $type, array $images): string;
}
