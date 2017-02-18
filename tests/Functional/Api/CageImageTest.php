<?php

namespace Tests\Functional\Api;

use Brunty\ApiTestCase;
use PHPUnit\Framework\Assert;

class CageImageTest extends ApiTestCase
{

    public function setUp()
    {
        $this->configureClientOptions(['headers' => ['Accept' => 'application/json']]);
        parent::setUp();
    }
    /**
     * @test
     */
    public function a_single_random_cage_image_is_returned()
    {
        $this->get('/random');
        $this->assertResponseOk();
        $this->assertResponseWasJson();
        $this->assertResponseHasKey('image');
    }

    /**
     * @param $number
     *
     * @test
     * @dataProvider provider_for_multiple_random_cage_images_are_returned
     */
    public function multiple_random_cage_images_are_returned($number)
    {
        self::markTestIncomplete('Multiple images not yet implemented.');
        $this->get(sprintf('/random/%d', $number));
        $this->assertResponseOk();
        $this->assertResponseWasJson();
        Assert::assertCount($number, $this->responseBody(true)['images']);
    }

    /**
     * @return array
     */
    public function provider_for_multiple_random_cage_images_are_returned()
    {
        return [
            [1],
            [2],
            [3],
            [4],
            [5],
            [6]
        ];
    }
}
