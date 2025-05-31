<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User; // Assuming you have a User model
use Illuminate\Support\Facades\Log; // For logging instead of actual email sending
use Illuminate\Mail\Mailables\Attachment;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user; // Public property to make it available in the Blade view

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to Our App, ' . $this->user->name . '!',
            // You can also set a 'from' address here if it's different from .env MAIL_FROM_ADDRESS
            // from: new Address('noreply@example.com', 'Our App Support'),
        );
    }

    /**
     * Get the message content definition.
     */
    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.welcome', // Refers to resources/views/emails/welcome.blade.php
            // You can pass data to the view like this, but public properties are automatically passed
            // with: [
            //     'orderName' => 'Example Order',
            // ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            // Example:
            Attachment::fromPath(public_path('docs/welcome.jpg'))
                ->as('Welcome.jpg')
                ->withMime('image/jpeg'),
            // Attachment::fromPath(public_path('docs/terms.pdf'))
            //     ->as('Terms & Conditions.pdf')
            //     ->withMime('application/pdf'),
        ];
    }
}
