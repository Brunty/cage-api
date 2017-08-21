<?php
declare(strict_types = 1);

namespace App\Presentation\RandomCage\SingleImage\Output;

use App\Domain\Entity\Image;

class XmlOutput
{

    public function createOutput(Image $image): string
    {
        $content = new \SimpleXMLElement('<xml />');
        $content->addChild('image', (string) $image);

        return $content->asXML();
    }
}
