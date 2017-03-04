<?php
declare(strict_types=1);

namespace App\Infrastructure\Event\Listener;

use App\Domain\Event\RandomCageImageViewed;
use League\Event\EventInterface;
use League\Event\ListenerInterface;
use Psr\Log\LoggerInterface;

final class ImageViewedListener implements ListenerInterface
{

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Handle an event.
     *
     * @param EventInterface|RandomCageImageViewed $event
     *
     * @return void
     */
    public function handle(EventInterface $event)
    {
        $this->logger->info(sprintf('Image viewed: %s', $event->getImage()));
    }

    /**
     * Check whether the listener is the given parameter.
     *
     * @param mixed $listener
     *
     * @return bool
     */
    public function isListener($listener)
    {
        return $listener === $this;
    }
}
