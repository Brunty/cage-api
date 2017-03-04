<?php
declare(strict_types=1);

namespace App\Presentation\RandomCage\MultipleImage\Output;

class XmlOutput
{

    public function createOutput(array $images): string
    {
        $content = new \SimpleXMLElement('<xml />');
        $imagesXmlNode = $content->addChild('images');

        foreach($images as $image) {
            $imagesXmlNode->addChild('image', (string)$image);
        }

        return $content->asXML();
    }
}
