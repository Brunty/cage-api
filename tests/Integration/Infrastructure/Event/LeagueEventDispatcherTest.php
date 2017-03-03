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
        $listener = $this->getListener();
        $testEvent = $this->getEvent('test_event');

        $dispatcher = new LeagueEventDispatcher(new Emitter);
        $dispatcher->addListener('test_event', $listener);
        $dispatcher->dispatch($testEvent);

        self::assertCount(1, $listener->getEvents());
        self::assertEquals('test_event', $listener->getEvents()[0]->getName());
    }


    /**
     * @test
     */
    public function it_emits_only_the_correct_events()
    {
        $listener = $this->getListener();
        $firstTestEvent = $this->getEvent('first_test_event');
        $secondTestEvent = $this->getEvent('second_test_event');

        $dispatcher = new LeagueEventDispatcher(new Emitter);
        $dispatcher->addListener('first_test_event', $listener);
        $dispatcher->dispatch($firstTestEvent);
        $dispatcher->dispatch($secondTestEvent);

        self::assertCount(1, $listener->getEvents());
        self::assertEquals('first_test_event', $listener->getEvents()[0]->getName());
    }

    private function getListener(): ListenerInterface
    {
        return new class implements ListenerInterface
        {

            protected $events = [];

            public function handle(EventInterface $event)
            {
                $this->events[] = $event;
            }

            public function isListener($listener): bool
            {
                return true;
            }

            public function getEvents(): array
            {
                return $this->events;
            }
        };
    }

    private function getEvent(string $name): Event
    {
        return new class($name) extends Event { };
    }
}
