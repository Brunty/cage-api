<?php
declare(strict_types=1);

namespace App\Presentation\Page\Homepage;

use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;

final class ContentCreator implements Creator
{

    /**
     * @var Twig
     */
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function createBody(ResponseInterface $response): ResponseInterface
    {
        return $this->twig->render($response, 'homepage.html.twig');
    }
}
