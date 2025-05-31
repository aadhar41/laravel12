<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Jobs\SendWelcomeEmail as JobsSendWelcomeEmail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendWelcomeEmail
{
    use InteractsWithQueue; // Add InteractsWithQueue for queued listeners

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event): void
    {
        Log::info(__METHOD__ . " Queued SendWelcomeEmail Listener: Processing User Registered event for user ID: {$event->user->id}, email: {$event->user->email}");
        // Retrieve the user from the event
        // Assuming the User model is already loaded in the event
        Log::info(__METHOD__ . " Queued SendWelcomeEmail Listener: User found with email: {$event->user->email}");
        // If you need to dispatch a job, you can do so here
        Log::info(__METHOD__ . " Queued SendWelcomeEmail Listener: Dispatching SendWelcomeEmail job for user ID: {$event->user->id}");
        // Dispatch the SendWelcomeEmail job
        $user = $event->user; // Assuming the user is passed in the event

        $user = User::find($event->user->id);

        if ($user) {
            // Dispatch specific jobs from within the listener
            JobsSendWelcomeEmail::dispatch($user);

            // Example of another job that might be dispatched
            // UpdateInventoryJob::dispatch($event->orderId);
            Log::info(__METHOD__ . " Queued SendWelcomeEmail Listener: Dispatched Sending welcome email to {$event->user->email}");
        } else {
            Log::warning(__METHOD__ . " Queued SendWelcomeEmail Listener: User not found for email: {$event->user->email}");
        }
    }
}
