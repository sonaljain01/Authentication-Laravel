<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Session;
use App\Services\CustomSessionHandler;
use App\Services\SessionHandlerInterface;
use App\Providers\AuthServiceProvider;

class CustomSessionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SessionHandlerInterface::class, CustomSessionHandler::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
