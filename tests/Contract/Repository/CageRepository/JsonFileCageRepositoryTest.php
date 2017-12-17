<?php

namespace Tests\Contract\Repository\CageRepository;

use App\Infrastructure\Repository\JsonFileCageRepository;

class JsonFileCageRepositoryTest extends CageRepositoryTest
{

    public function setUp()
    {
        $this->repository = new JsonFileCageRepository(__DIR__ . '/../../../Resources/cages.json');
        parent::setUp();
    }
}
