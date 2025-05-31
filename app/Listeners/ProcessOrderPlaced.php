<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\SendOrderConfirmationEmail; // Our existing job
use App\Models\User; // To retrieve the user for the email job
use Illuminate\Support\Facades\Log;

class ProcessOrderPlaced
{
    use InteractsWithQueue;

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
    public function handle(OrderPlaced $event): void
    {
        Log::info(__METHOD__ . " Queued Listener: Processing Order Placed event for Order ID: {$event->orderId}");

        $user = User::find($event->userId);

        if ($user) {
            // Dispatch specific jobs from within the listener
            SendOrderConfirmationEmail::dispatch($user, $event->orderId);

            // Example of another job that might be dispatched
            // UpdateInventoryJob::dispatch($event->orderId);
            Log::info(__METHOD__ . " Queued Listener: Dispatched SendOrderConfirmationEmail job for Order ID: {$event->orderId}");
        } else {
            Log::warning(__METHOD__ . " Queued Listener: User not found for Order ID: {$event->orderId}");
        }
    }
}
