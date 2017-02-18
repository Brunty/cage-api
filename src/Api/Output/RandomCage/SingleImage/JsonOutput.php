<?php

namespace App\Api\Output\RandomCage\SingleImage;

use App\Api\Output\Output;
use App\Domain\Model\Image;

final class JsonOutput
{

    public function createOutput(Image $image): string
    {
        return json_encode(['image' => (string) $image]);
    }
}
