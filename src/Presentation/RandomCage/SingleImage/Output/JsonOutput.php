<?php
declare(strict_types = 1);

namespace App\Presentation\RandomCage\SingleImage\Output;

use App\Domain\Entity\Image;

class JsonOutput
{

    public function createOutput(Image $image): string
    {
        return json_encode(['image' => (string) $image]);
    }
}
