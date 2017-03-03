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

    /**
     * @param string $contentType
     * @param int    $number
     *
     * @param string $assertion
     *
     * @test
     * @dataProvider provider_for_multiple_random_cage_images_are_returned
     */
    public function multiple_random_cage_images_are_returned(string $contentType, int $number, string $assertion)
    {
        $this->get(sprintf('/bomb/%d', $number), ['headers' => ['Accept' => $contentType]]);
        $this->assertResponseOk();
        $this->$assertion();
        Assert::assertCount($number, $this->responseBody(true)['images']);
    }

    /**
     * @return array
     */
    public function provider_for_multiple_random_cage_images_are_returned()
    {
        return [
            ['application/json', 1, 'assertResponseWasJson'],
            ['application/json', 2, 'assertResponseWasJson'],
            ['application/json', 3, 'assertResponseWasJson'],
            ['application/json', 4, 'assertResponseWasJson'],
            ['application/json', 5, 'assertResponseWasJson'],
            ['application/json', 6, 'assertResponseWasJson']
        ];
    }
}
