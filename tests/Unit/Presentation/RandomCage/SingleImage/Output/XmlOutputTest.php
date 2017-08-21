<?php

namespace Tests\Unit\Presentation\RandomCage\SingleImage\Output;

use App\Domain\Entity\Image;
use App\Domain\Value\Url;
use App\Presentation\RandomCage\SingleImage\Output\XmlOutput;

class XmlOutputTest extends \PHPUnit\Framework\TestCase
{

    /** @test */
    public function it_creates_xml_from_an_image()
    {
        $image = new Image(new Url('http://site.tld/thisisanimagesourceurl.png'));
        $output = (new XmlOutput())->createOutput($image);

        $expected = <<<XML
<?xml version="1.0"?>
<xml><image>http://site.tld/thisisanimagesourceurl.png</image></xml>

XML;

        self::assertEquals($expected, $output);
    }
}
