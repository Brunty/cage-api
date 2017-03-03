<?php

namespace App\Presentation\Page\Homepage;

use Psr\Http\Message\ResponseInterface;

interface Creator
{

    public function createBody(ResponseInterface $response): ResponseInterface;
}
