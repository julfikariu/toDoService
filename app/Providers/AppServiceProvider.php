<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\EventPublisherInterface;
use App\Services\Publishers\RedisEventPublisher;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(EventPublisherInterface::class, RedisEventPublisher::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
