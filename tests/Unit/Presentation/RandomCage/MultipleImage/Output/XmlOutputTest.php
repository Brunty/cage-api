<?php

namespace Tests\Unit\Presentation\RandomCage\MultipleImage\Output;

use App\Domain\Model\Image;
use App\Presentation\RandomCage\MultipleImage\Output\XmlOutput;

class XmlOutputTest extends \PHPUnit\Framework\TestCase
{

    /** @test */
    public function it_creates_xml_from_an_image()
    {
        $images = [new Image('thisisanimagesourceurl'), new Image('2ndsourceurl')];
        $output = (new XmlOutput())->createOutput($images);

        $expected = <<<XML
<?xml version="1.0"?>
<xml><images><image>thisisanimagesourceurl</image><image>2ndsourceurl</image></images></xml>

XML;

        self::assertEquals($expected, $output);
    }
}
