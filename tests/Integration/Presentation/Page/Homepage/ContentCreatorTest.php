<?php

namespace Tests\Integration\Presentation\Page\Homepage;

use App\Presentation\Page\Homepage\ContentCreator;
use Slim\Http\Response;
use Tests\AppTestCase;

class ContentCreatorTest extends AppTestCase
{

    /**
     * @test
     */
    public function it_creates_the_html_from_a_template()
    {
        $creator = new ContentCreator($this->container->get('view'));
        self::assertNotFalse(strpos($creator->createBody(new Response), 'CAGE!'));
    }
}
