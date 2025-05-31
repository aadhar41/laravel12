<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue; // This is not needed if you don't want it queued
use Illuminate\Queue\InteractsWithQueue; // Not needed if not queued
use Illuminate\Support\Facades\Log;


class LogUserActivity
{
    /**
     * Create the event listener.
     *
     * @return void
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
        // This will execute synchronously with the HTTP request
        Log::info(__METHOD__ . " Synchronous Listener: User activity logged for user ID: {$event->user->id}, email: {$event->user->email}");
    }
}
