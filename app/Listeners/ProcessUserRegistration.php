<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\UserRegistered;     // Import our event
use App\Jobs\SendWelcomeEmailJob;  // Import our email job
use Illuminate\Support\Facades\Log; // For logging

class ProcessUserRegistration
{
    use InteractsWithQueue; // Required for queued listeners

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        Log::info(__METHOD__ . " ProcessUserRegistration Listener: Processing UserRegistered event for user: {$event->user->email}");

        // Dispatch the email sending job
        SendWelcomeEmailJob::dispatch($event->user);

        Log::info(__METHOD__ . " ProcessUserRegistration Listener: Dispatched SendWelcomeEmailJob for user: {$event->user->email}");
    }
}