<?php

namespace Tests\Unit\Presentation\RandomCage\MultipleImage;

use App\Domain\Collection\ImageCollection;
use App\Domain\Entity\Image;
use App\Domain\Value\Url;
use App\Presentation\RandomCage\MultipleImage\ContentCreator;

class ContentCreatorTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @test
     * @dataProvider provider_for_it_creates_output_based_on_a_type
     *
     * @param string $type
     * @param string $expectedOutput
     */
    public function it_creates_output_based_on_a_type($type, $expectedOutput)
    {
        $creator = new ContentCreator;
        $images = new ImageCollection([new Image(new Url('http://site.tld/thisisanimagesourceurl.png')), new Image(new Url('http://site.tld/2ndsourceurl.png'))]);

        self::assertEquals($expectedOutput, $creator->createBody($type, $images));
    }

    public function provider_for_it_creates_output_based_on_a_type()
    {
        $expectedXml = <<<XML
<?xml version="1.0"?>
<xml><images><image>http://site.tld/thisisanimagesourceurl.png</image><image>http://site.tld/2ndsourceurl.png</image></images></xml>

XML;
        $expectedJson = '{"images":["http:\/\/site.tld\/thisisanimagesourceurl.png","http:\/\/site.tld\/2ndsourceurl.png"]}';
        return [
            ['application/xml', $expectedXml],
            ['application/json', $expectedJson],
            ['application/thisfallsbacktodefault', $expectedJson],
        ];
    }
}
