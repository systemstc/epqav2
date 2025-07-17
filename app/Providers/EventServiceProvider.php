<?php

namespace App\Providers;

use App\Events\UserRegistered;
use App\Listeners\SendOtpEmail;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

// use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
        protected $listen = [
            UserRegistered::class => [
                SendOtpEmail::class,
            ],
            UserLoginOtp::class => [
                SendLoginOtp::class,
            ],
        ];
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Event::listen(
        //     UserRegistered::class,
        //     SendOtpEmail::class,
        // );
        parent::boot();
    }
}
