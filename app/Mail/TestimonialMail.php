<?php

namespace App\Mail;

use App\Models\Program;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestimonialMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $token;
    public $program;

    /**
     * Create a new message instance.
     */
    public function __construct($token, Program $program)
    {
        $this->token = $token;
        $this->program = $program;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mohon Kesan dan Pesan Anda - ' . $this->program->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.testimonial', // We will need to create this view
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
