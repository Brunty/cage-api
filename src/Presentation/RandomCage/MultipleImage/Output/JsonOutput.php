<?php

namespace App\Presentation\RandomCage\MultipleImage\Output;

use App\Domain\Model\Image;

class JsonOutput
{

    public function createOutput(array $images): string
    {
        $images = array_map(function(Image $image) {
            return (string) $image;
        }, $images);

        return json_encode(['images' => $images]);
    }
}
