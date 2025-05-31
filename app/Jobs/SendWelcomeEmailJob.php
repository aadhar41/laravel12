<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\WelcomeEmail; // Import our Mailable
use App\Models\User;      // Import the User model
use Illuminate\Support\Facades\Mail; // Import Mail facade
use Illuminate\Support\Facades\Log; // For logging

class SendWelcomeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3; // Retry up to 3 times if it fails

    /**
     * The maximum number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 120; // Allow up to 120 seconds for the email to send

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
        Log::info(__METHOD__ . " Attempting to send welcome email to user: {$this->user->email}");

        try {
            Mail::to($this->user->email)->send(new WelcomeEmail($this->user));
            Log::info(__METHOD__ . " Successfully sent welcome email to user: {$this->user->email}");
        } catch (\Exception $e) {
            Log::error(__METHOD__ . " Failed to send welcome email to {$this->user->email}: " . $e->getMessage());
            // If you want to mark the job as failed and have it retried, you can re-throw the exception
            throw $e;
        }
    }
}