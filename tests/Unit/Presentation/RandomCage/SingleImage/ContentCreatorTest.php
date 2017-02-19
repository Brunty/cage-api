<?php

namespace Tests\Unit\Presentation\RandomCage\SingleImage;

use App\Domain\Model\Image;
use App\Presentation\RandomCage\SingleImage\ContentCreator;

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
        $image = new Image('thisisanimagesourceurl');

        self::assertEquals($expectedOutput, $creator->createBody($type, $image));
    }

    public function provider_for_it_creates_output_based_on_a_type()
    {
        $expectedXml = <<<XML
<?xml version="1.0"?>
<xml><image>thisisanimagesourceurl</image></xml>

XML;
        $expectedJson = '{"image":"thisisanimagesourceurl"}';
        return [
            ['application/xml', $expectedXml],
            ['application/json', $expectedJson],
            ['application/thisfallsbacktodefault', $expectedJson],
        ];
    }
}
