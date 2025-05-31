<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\OrderPlaced;
use App\Events\UserRegistered;
use App\Listeners\LogUserActivity;
use App\Listeners\ProcessOrderPlaced;
use App\Listeners\ProcessUserRegistration;
use App\Listeners\SendWelcomeEmail;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrderPlaced::class => [
            ProcessOrderPlaced::class, // This will be queued
        ],
        // Our custom event and its listeners
        UserRegistered::class => [
            ProcessUserRegistration::class, // This can be queued
            SendWelcomeEmail::class, // This can be queued
            LogUserActivity::class, // This can be synchronous or queued
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
