<?php

namespace Tests\Integration\Infrastructure\Event;

use App\Infrastructure\Event\LeagueEventDispatcher;
use League\Event\Emitter;
use League\Event\Event;
use League\Event\EventInterface;
use League\Event\ListenerInterface;
use PHPUnit\Framework\TestCase;

class LeagueEventDispatcherTest extends TestCase
{

    /**
     * @test
     */
    public function it_emits_events()
    {
        $listener = new class implements ListenerInterface
        {

            /**
             * @var EventInterface[]
             */
            protected $events = [];

            /**
             * @inheritdoc
             */
            public function handle(EventInterface $event)
            {
                $this->events[] = $event;
            }

            /**
             * @inheritdoc
             */
            public function isListener($listener): bool
            {
                return true;
            }

            public function getEvents(): array
            {
                return $this->events;
            }
        };
        $dispatcher = new LeagueEventDispatcher(new Emitter);
        $dispatcher->addListener('event', $listener);
        $dispatcher->dispatch(
            new class('event') extends Event
            {

            }
        );

        self::assertNotEmpty($listener->getEvents());
    }
}
