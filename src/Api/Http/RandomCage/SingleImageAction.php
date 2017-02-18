<?php

namespace App\Api\Http\RandomCage;

use App\Api\Responder\RandomCage\SingleImageResponder;
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
     * @var SingleImageResponder
     */
    private $responder;

    public function __construct(CageRepository $repository, SingleImageResponder $responder)
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
