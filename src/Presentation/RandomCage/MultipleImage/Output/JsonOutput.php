<?php
declare(strict_types = 1);

namespace App\Presentation\RandomCage\MultipleImage\Output;

use App\Domain\Collection\ImageCollection;
use App\Domain\Model\Image;

class JsonOutput
{

    public function createOutput(ImageCollection $images): string
    {
        $images = $images->map(
            function (Image $image) {
                return (string) $image;
            }
        )->toArray();

        return json_encode(['images' => $images]);
    }
}
