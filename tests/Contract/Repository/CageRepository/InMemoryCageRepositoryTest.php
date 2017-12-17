<?php

namespace Tests\Contract\Repository\CageRepository;

use Tests\Double\Repository\InMemoryCageRepository;

class InMemoryCageRepositoryTest extends CageRepositoryTest
{

    public function setUp()
    {
        $this->repository = new InMemoryCageRepository;
        parent::setUp();
    }
}
