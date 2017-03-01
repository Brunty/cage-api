<?php

namespace Tests\Unit\Presentation\RandomCage\MultipleImage\Output;

use App\Domain\Model\Image;
use App\Presentation\RandomCage\MultipleImage\Output\JsonOutput;

class JsonOutputTest extends \PHPUnit\Framework\TestCase
{

    /** @test */
    public function it_creates_json_from_an_image()
    {
        $images = [new Image('thisisanimagesourceurl'), new Image('2ndsourceurl')];
        $output = (new JsonOutput())->createOutput($images);

        $expected = '{"images":["thisisanimagesourceurl","2ndsourceurl"]}';

        self::assertEquals($expected, $output);
    }
}
