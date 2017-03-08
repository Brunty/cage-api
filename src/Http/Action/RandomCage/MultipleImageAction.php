<?php
declare(strict_types = 1);

namespace App\Http\Action\RandomCage;

use App\Domain\Collection\ImageCollection;
use App\Http\Responder\RandomCage\MultipleImage\Responder;
use App\Domain\Repository\CageRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MultipleImageAction
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
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        $responder = $this->responder;

        $images = new ImageCollection;

        try {
            $images = $this->repository->getRandomCageImages((int) $args['number']);
        } catch (\OutOfRangeException $e) {
            $this->responder->setException($e);
        }

        return $responder($request, $response, $images);
    }
}
