<?php

namespace Tests\Unit\Presentation\RandomCage\SingleImage\Output;

use App\Domain\Entity\Image;
use App\Domain\Value\Url;
use App\Presentation\RandomCage\SingleImage\Output\JsonOutput;

class JsonOutputTest extends \PHPUnit\Framework\TestCase
{

    /** @test */
    public function it_creates_json_from_an_image()
    {
        $image = new Image(new Url('http://site.tld/thisisanimagesourceurl.png'));
        $output = (new JsonOutput())->createOutput($image);

        $expected = '{"image":"http:\/\/site.tld\/thisisanimagesourceurl.png"}';

        self::assertEquals($expected, $output);
    }
}
