<?php
declare(strict_types=1);

namespace App\Http\Action\RandomCage;

use App\Http\Responder\RandomCage\SingleImage\Responder;
use App\Domain\Repository\CageRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SingleImageAction
{

    /**
     * @var CageRepository
     */
    private $repository;

    /**
     * @var Responder
     */
    private $responder;

    public function __construct(CageRepository $repository, Responder $responder)
    {
        $this->repository = $repository;
        $this->responder = $responder;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $image = $this->repository->getRandomCageImage();

        $responder = $this->responder;

        return $responder($request, $response, $image);
    }
}
