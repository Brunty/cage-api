<?php

namespace App\Infrastructure\Event;

use App\Domain\Event\EventDispatcher;
use League\Event\Emitter;
use League\Event\EventInterface;
use League\Event\ListenerInterface;

class LeagueEventDispatcher implements EventDispatcher
{

    /**
     * @var Emitter
     */
    private $emitter;

    public function __construct(Emitter $emitter)
    {
        $this->emitter = $emitter;
    }

    public function dispatch(EventInterface $event)
    {
        $this->emitter->emit($event);
    }

    public function addListener(string $eventName, ListenerInterface $listener)
    {
        $this->emitter->addListener($eventName, $listener);
    }
}
