<?php

namespace App\Api\Presentation\RandomCage\SingleImage;

use App\Api\Presentation\RandomCage\SingleImage\Output\JsonOutput;
use App\Api\Presentation\RandomCage\SingleImage\Output\XmlOutput;
use App\Domain\Model\Image;

class Creator
{

    public function createBody(string $type, Image $image): string
    {
        switch ($type) {
            case 'application/xml':
                return (new XmlOutput())->createOutput($image);
                break;
            case 'application/json':
            default:
                return (new JsonOutput())->createOutput($image);
        }
    }
}
