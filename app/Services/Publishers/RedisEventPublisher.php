<?php

namespace App\Services\Publishers;

use App\Contracts\EventPublisherInterface;
use Illuminate\Support\Facades\Redis;

class RedisEventPublisher implements EventPublisherInterface
{
    /**
     * Publish an event to a Redis list.
     *
     * @param string $queue
     * @param array $payload
     * @return void
     */
    public function publish(string $queue, array $payload): void
    {
        Redis::lpush($queue, json_encode($payload));
    }
}
