<?php

namespace App\Presentation\RandomCage\MultipleImage;

use App\Domain\Collection\ImageCollection;

interface Creator
{

    public function createBody(string $type, ImageCollection $images): string;
}
