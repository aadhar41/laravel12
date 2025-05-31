<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User; // Assuming you have a User model
use Illuminate\Support\Facades\Log; // For logging instead of actual email sending

class SendOrderConfirmationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $orderId;

    /**
     * Create a new job instance.
     *
     * @param \App\Models\User $user
     * @param int $orderId
     */
    public function __construct(User $user, int $orderId)
    {
        $this->user = $user;
        $this->orderId = $orderId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        // Simulate sending an email. In a real app, you'd use Mail::to()->send(new OrderConfirmationMailable($orderId));
        Log::info("Jobs: Sending order confirmation email for Order ID: {$this->orderId} to user: {$this->user->email}");

        // Simulate some delay for a long-running task
        sleep(5); // Sleep for 5 seconds

        Log::info("Jobs: Order confirmation email sent for Order ID: {$this->orderId} to user: {$this->user->email}");
    }
}
