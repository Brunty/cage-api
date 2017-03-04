<?php
declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Event\EventDispatcher;
use App\Domain\Event\RandomCageImageViewed;
use App\Domain\Model\Image;
use App\Domain\Repository\CageRepository;

final class EventDispatchingJsonFileCageRepository implements CageRepository
{

    /**
     * @var CageRepository
     */
    private $repository;

    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    public function __construct(CageRepository $repository, EventDispatcher $dispatcher)
    {
        $this->repository = $repository;
        $this->dispatcher = $dispatcher;
    }

    public function getRandomCageImage(): Image
    {
        $image = $this->repository->getRandomCageImage();

        $this->dispatcher->dispatch(new RandomCageImageViewed($image));

        return $image;
    }

    public function getRandomCageImages(int $count = 5): array
    {
        return $this->repository->getRandomCageImages($count);
    }
}
