<?php

namespace Tests\Unit\Presentation\RandomCage\SingleImage\Output;

use App\Domain\Model\Image;
use App\Presentation\RandomCage\SingleImage\Output\JsonOutput;

class JsonOutputTest extends \PHPUnit\Framework\TestCase
{

    /** @test */
    public function it_creates_json_from_an_image()
    {
        $image = new Image('thisisanimagesourceurl');
        $output = (new JsonOutput())->createOutput($image);

        $expected = '{"image":"thisisanimagesourceurl"}';

        self::assertEquals($expected, $output);
    }
}
