<?php

namespace App\Presentation\RandomCage\MultipleImage\Output;

class XmlOutput
{

    public function createOutput(array $images): string
    {
        $content = new \SimpleXMLElement('<xml />');
        $imagesXmlNode = $content->addChild('images');

        foreach($images as $image) {
            $imagesXmlNode->addChild('image', $image);
        }

        return $content->asXML();
    }
}
