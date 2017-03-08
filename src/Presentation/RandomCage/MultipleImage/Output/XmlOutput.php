<?php
declare(strict_types = 1);

namespace App\Presentation\RandomCage\MultipleImage\Output;

use App\Domain\Collection\ImageCollection;

class XmlOutput
{

    public function createOutput(ImageCollection $images): string
    {
        $content = new \SimpleXMLElement('<xml />');
        $imagesXmlNode = $content->addChild('images');

        foreach ($images as $image) {
            $imagesXmlNode->addChild('image', (string) $image);
        }

        return $content->asXML();
    }
}
