<?php

namespace App\Domain\Repository;

use App\Domain\Model\Image;

interface CageRepository
{

    public function getRandomCageImage(): Image;

    public function getRandomCageImages(int $count = 5): array;

    public function getAllCageImages(): array;

    public function getCageImageCount(): int;

    public function getAllCageQuotes(): array;

    public function getRandomCageQuote(): string;

    public function getCageIpsum(int $sentences = 10): string;
}
