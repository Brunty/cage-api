<?php
declare(strict_types=1);

namespace App\Presentation\RandomCage\MultipleImage;

use App\Domain\Collection\ImageCollection;
use App\Presentation\RandomCage\MultipleImage\Output\JsonOutput;
use App\Presentation\RandomCage\MultipleImage\Output\XmlOutput;

final class ContentCreator implements Creator
{

    public function createBody(string $type, ImageCollection $images): string
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
