<?php

namespace Tests\Functional\Api;

use Brunty\ApiTestCase;
use PHPUnit\Framework\Assert;

class CageImageTest extends ApiTestCase
{

    /**
     * @test
     * @dataProvider provider_for_a_single_random_cage_image_is_returned
     *
     * @param string $contentType
     * @param string $assertion
     */
    public function a_single_random_cage_image_is_returned(string $contentType, string $assertion)
    {
        $this->get('/random', ['headers' => ['Accept' => $contentType]]);
        $this->assertResponseOk();
        $this->$assertion();
        $this->assertResponseHasKey('image');
    }

    /**
     * @return array
     */
    public function provider_for_a_single_random_cage_image_is_returned()
    {
        return [
            ['application/xml', 'assertResponseWasXml'],
            ['application/json', 'assertResponseWasJson'],
        ];
    }

//    /**
//     * @param $number
//     *
//     * @test
//     * @dataProvider provider_for_multiple_random_cage_images_are_returned
//     */
//    public function multiple_random_cage_images_are_returned($number)
//    {
//        self::markTestIncomplete('Multiple images not yet implemented.');
//        $this->get(sprintf('/random/%d', $number));
//        $this->assertResponseOk();
//        $this->assertResponseWasJson();
//        Assert::assertCount($number, $this->responseBody(true)['images']);
//    }
//
//    /**
//     * @return array
//     */
//    public function provider_for_multiple_random_cage_images_are_returned()
//    {
//        return [
//            [1],
//            [2],
//            [3],
//            [4],
//            [5],
//            [6]
//        ];
//    }
}
