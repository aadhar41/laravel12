<?php

namespace App\Jobs;

use App\Models\User; // Assuming you have a User model
use Illuminate\Support\Facades\Log; // For logging instead of actual email sending
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWelcomeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @param \App\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Simulate sending an email. In a real app, you'd use Mail::to()->send(new OrderConfirmationMailable($orderId));
        Log::info(__METHOD__ . " Jobs: Sending welcome email to user: {$this->user->email}");

        // Simulate some delay for a long-running task
        sleep(5); // Sleep for 5 seconds

        Log::info(__METHOD__ . " Jobs: Welcome email sent to user: {$this->user->email}");
    }
}
