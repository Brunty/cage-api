<?php

namespace Tests\Unit\Presentation\RandomCage\MultipleImage\Output;

use App\Domain\Collection\ImageCollection;
use App\Domain\Entity\Image;
use App\Domain\Value\Url;
use App\Presentation\RandomCage\MultipleImage\Output\JsonOutput;

class JsonOutputTest extends \PHPUnit\Framework\TestCase
{

    /** @test */
    public function it_creates_json_from_an_image()
    {
        $images = new ImageCollection([new Image(new Url('http://site.tld/thisisanimagesourceurl.png')), new Image(new Url('http://site.tld/2ndsourceurl.png'))]);
        $output = (new JsonOutput())->createOutput($images);

        $expected = '{"images":["http:\/\/site.tld\/thisisanimagesourceurl.png","http:\/\/site.tld\/2ndsourceurl.png"]}';

        self::assertEquals($expected, $output);
    }
}
