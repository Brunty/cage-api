<?php declare(strict_types=1);

namespace App;

use Slim\App;

class Kernel extends App
{
    /**
     * @var string
     */
    private $env;

    public function __construct(array $settings, string $env = 'prod')
    {
        parent::__construct($settings);
        $this->env = $env;
    }

    public function loadConfig(string $dir)
    {
        foreach (['errors', 'dependencies', 'middleware', 'routes'] as $file) {
            require "{$dir}{$file}.php";

            $this->loadFileForEnv($dir, $file);
        }
    }

    private function loadFileForEnv(string $dir, string $file)
    {
        if (file_exists($dir . $this->env . "/{$file}.php")) {
            require $dir . $this->env . "/{$file}.php";
        }
    }
}
