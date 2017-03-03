<?php

namespace Tests\Integration\Infrastructure\Event;

use App\Domain\Event\RandomCageImageViewed;
use App\Domain\Model\Image;
use App\Infrastructure\Event\LeagueEventDispatcher;
use App\Infrastructure\Event\Listener\ImageViewedListener;
use League\Event\Emitter;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;

class LeagueEventDispatcherTest extends TestCase
{

    /**
     * @test
     */
    public function it_emits_events()
    {
        $handler = new class extends AbstractProcessingHandler
        {

            /**
             * @var array
             */
            protected $logs = [];

            /**
             * Writes the record down to the log of the implementing handler
             *
             * @param  array $record
             *
             * @return void
             */
            protected function write(array $record)
            {
                $this->logs[] = $record;
            }

            public function getLogs(): array
            {
                return $this->logs;
            }
        };
        $dispatcher = new LeagueEventDispatcher(new Emitter);
        $dispatcher->addListener(
            RandomCageImageViewed::class,
            new ImageViewedListener(new Logger('logger', [$handler]))
        );
        $dispatcher->dispatch(new RandomCageImageViewed(new Image('imageurl')));

        self::assertNotEmpty($handler->getLogs());
        self::assertEquals('Image viewed: imageurl', $handler->getLogs()[0]['message']);
    }
}
