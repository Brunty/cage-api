<?php
declare(strict_types=1);

namespace Tests\Functional\Api;

use Brunty\ApiTestCase;
use PHPUnit\Framework\Assert;

class CageImageTest extends ApiTestCase
{

    /**
     * @test
     * @dataProvider content_type_provider
     */
    public function a_single_random_cage_image_is_returned(string $contentType, string $assertion)
    {
        $this->get('/random', ['headers' => ['Accept' => $contentType]]);
        $this->assertResponseOk();
        $this->$assertion();
        $this->assertResponseHasKey('image');
    }

    public function content_type_provider(): array
    {
        return [
            'XML'  => ['application/xml', 'assertResponseWasXml'],
            'JSON' => ['application/json', 'assertResponseWasJson'],
        ];
    }

    /**
     * @test
     * @dataProvider multiple_image_provider
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
    public function multiple_image_provider(): array
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
