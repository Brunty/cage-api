<?php

namespace App\Presentation\RandomCage\SingleImage\Output;

use App\Domain\Model\Image;

final class JsonOutput
{

    public function createOutput(Image $image): string
    {
        return json_encode(['image' => (string) $image]);
    }
}
