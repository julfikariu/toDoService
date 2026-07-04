<?php

namespace App\Contracts;

interface EventPublisherInterface
{
    /**
     * Publish an event to a queue or topic.
     *
     * @param string $queue
     * @param array $payload
     * @return void
     */
    public function publish(string $queue, array $payload): void;
}
