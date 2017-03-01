<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Image;
use App\Domain\Repository\CageRepository;
use OutOfRangeException;

final class JsonFileCageRepository implements CageRepository
{
    CONST MAX_BOMB_CAGES = 10;

    /**
     * @var array
     */
    protected $cages = [];

    /**
     * @var string
     */
    protected $storageFilePath;

    /**
     * @var array
     */
    protected $cageQuotes = [];
    
    public function __construct(string $storageFilePath)
    {
        $this->storageFilePath = $storageFilePath;
    }

    public function getStorageFilePath(): string
    {
        return $this->storageFilePath;
    }

    public function getRandomCageImage(): Image
    {
        return new Image($this->getRandomCageImages(1)[0]);
    }

    public function getRandomCageImages(int $count = 5): array
    {
        /* move this to service class as it's basically validation? Don't like it in repo, oh well... */
        if ($count > self::MAX_BOMB_CAGES) {
            throw new OutOfRangeException(
                sprintf(
                    'YOU WANT %d?! THAT\'S TOO MANY CAGES. I CAN\'T HANDLE THAT! (Best I can do is %d...)',
                    $count,
                    self::MAX_BOMB_CAGES
                )
            );
        }

        // ALL THE CAGES!
        $cages = $this->getAllCageImages();

        // Randomise those Cages!
        shuffle($cages);

        return array_map(function($string) { return new Image($string); } , array_slice($cages, 0, $count));
    }

    public function getAllCageImages(): array
    {
        $fileContents = json_decode(file_get_contents($this->getStorageFilePath()), true);

        $this->cages = $fileContents['cages'];

        return $this->cages;
    }

    public function getCageImageCount(): int
    {
        return count($this->getAllCageImages());
    }


    public function getAllCageQuotes(): array
    {
        $fileContents = json_decode(file_get_contents($this->getStorageFilePath()), true);

        $this->cageQuotes = $fileContents['cage_quotes'];

        return $this->cageQuotes;
    }

    public function getRandomCageQuote(): string
    {
        return $this->getAllCageQuotes()[rand(0, $this->getMaxQuoteIndex())];
    }

    public function getCageIpsum(int $sentences = 10): string
    {
        $quotes = $this->getAllCageQuotes();
        $wordString = implode(' ', $quotes);
        $wordString = str_replace('.', '', $wordString);
        $wordArray = explode(' ', $wordString);
        $ipsum = [];

        while (count($ipsum) < $sentences) {
            $wordsInSentence = rand(6, 11);
            $wordsForSentence = [];

            while (count($wordsForSentence) < $wordsInSentence) {
                shuffle($wordArray);
                $wordsForSentence[] = $wordArray[0];
            }

            $string = implode(' ', $wordsForSentence);
            $string = ucfirst($string);
            $string = trim($string, ',\'\"'); // trim off any trailing punctuation, so we don't end up messy.
            $ipsum[] = $string;
        }

        return implode('. ', $ipsum) . '.';
    }

    private function getMaxQuoteIndex(): int
    {
        return count($this->getAllCageQuotes()) - 1;
    }
}
