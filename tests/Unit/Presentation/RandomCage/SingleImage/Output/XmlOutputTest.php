<?php

namespace Tests\Unit\Presentation\RandomCage\SingleImage\Output;

use App\Domain\Model\Image;
use App\Presentation\RandomCage\SingleImage\Output\XmlOutput;

class XmlOutputTest extends \PHPUnit\Framework\TestCase
{

    /** @test */
    public function it_creates_xml_from_an_image()
    {
        $image = new Image('thisisanimagesourceurl');
        $output = (new XmlOutput())->createOutput($image);

        $expected = <<<XML
<?xml version="1.0"?>
<xml><image>thisisanimagesourceurl</image></xml>

XML;

        self::assertEquals($expected, $output);
    }
}
