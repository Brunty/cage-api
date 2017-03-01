<?php

namespace App\Presentation\RandomCage\MultipleImage;

use App\Presentation\RandomCage\MultipleImage\Output\JsonOutput;
use App\Presentation\RandomCage\MultipleImage\Output\XmlOutput;
use App\Domain\Model\Image;

class ContentCreator implements Creator
{

    public function createBody(string $type, array $images): string
    {
        switch ($type) {
            case 'application/xml':
                return (new XmlOutput())->createOutput($images);
                break;
            case 'application/json':
            default:
                return (new JsonOutput())->createOutput($images);
        }
    }
}
