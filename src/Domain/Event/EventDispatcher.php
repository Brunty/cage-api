<?php

namespace App\Domain\Event;

use League\Event\EventInterface;
use League\Event\ListenerInterface;

interface EventDispatcher
{

    public function dispatch(EventInterface $event);

    public function addListener(string $eventName, ListenerInterface $listener);
}
