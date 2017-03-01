<?php

namespace App\Presentation\RandomCage\MultipleImage\Output;

class JsonOutput
{

    public function createOutput(array $images): string
    {
        return json_encode(['images' => $images]);
    }
}
