<?php

namespace Tests\Unit\Presentation\RandomCage\MultipleImage\Output;

use App\Domain\Collection\ImageCollection;
use App\Domain\Entity\Image;
use App\Domain\Value\Url;
use App\Presentation\RandomCage\MultipleImage\Output\XmlOutput;

class XmlOutputTest extends \PHPUnit\Framework\TestCase
{

    /** @test */
    public function it_creates_xml_from_an_image()
    {
        $images = new ImageCollection([new Image(new Url('http://site.tld/thisisanimagesourceurl.png')), new Image(new Url('http://site.tld/2ndsourceurl.png'))]);
        $output = (new XmlOutput())->createOutput($images);

        $expected = <<<XML
<?xml version="1.0"?>
<xml><images><image>http://site.tld/thisisanimagesourceurl.png</image><image>http://site.tld/2ndsourceurl.png</image></images></xml>

XML;

        self::assertEquals($expected, $output);
    }
}
