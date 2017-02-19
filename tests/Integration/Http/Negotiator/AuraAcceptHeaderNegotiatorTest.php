<?php

namespace Tests\Integration\Http\Negotiator;

use App\Http\Negotiator\AuraAcceptHeaderNegotiator;
use Aura\Accept\AcceptFactory;
use PHPUnit\Framework\TestCase;

class AuraAcceptHeaderNegotiatorTest extends TestCase
{

    /**
     * @test
     * @expectedException \App\Http\Negotiator\UnavailableContentTypeException
     */
    public function it_throws_an_exception_if_no_content_type_is_available()
    {
        $accept = (new AcceptFactory(['HTTP_ACCEPT' => 'application/json']))->newInstance();
        $negotiator = new AuraAcceptHeaderNegotiator($accept);

        $negotiator->negotiate([]);
    }


    /**
     * @test
     */
    public function it_returns_the_type_if_content_type_is_available()
    {
        $accept = (new AcceptFactory(['HTTP_ACCEPT' => 'application/json']))->newInstance();
        $negotiator = new AuraAcceptHeaderNegotiator($accept);

        $type = $negotiator->negotiate(['application/json', 'application/xml']);

        self::assertEquals('application/json', $type);
    }
}
