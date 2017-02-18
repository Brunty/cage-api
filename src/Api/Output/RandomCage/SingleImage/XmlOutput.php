<?php

namespace App\Api\Output\RandomCage\SingleImage;

use App\Api\Output\Output;
use App\Domain\Model\Image;

final class XmlOutput
{

    public function createOutput(Image $image): string
    {
        $content = new \SimpleXMLElement('<xml />');
        $content->addChild('image', (string) $image);

        return $content->asXML();
    }
}
