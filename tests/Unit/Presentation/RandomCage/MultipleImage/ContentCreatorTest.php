<?php

namespace Tests\Unit\Presentation\RandomCage\MultipleImage;

use App\Domain\Collection\ImageCollection;
use App\Domain\Model\Image;
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
        $images = new ImageCollection([new Image('thisisanimagesourceurl'), new Image('2ndsourceurl')]);

        self::assertEquals($expectedOutput, $creator->createBody($type, $images));
    }

    public function provider_for_it_creates_output_based_on_a_type()
    {
        $expectedXml = <<<XML
<?xml version="1.0"?>
<xml><images><image>thisisanimagesourceurl</image><image>2ndsourceurl</image></images></xml>

XML;
        $expectedJson = '{"images":["thisisanimagesourceurl","2ndsourceurl"]}';
        return [
            ['application/xml', $expectedXml],
            ['application/json', $expectedJson],
            ['application/thisfallsbacktodefault', $expectedJson],
        ];
    }
}
