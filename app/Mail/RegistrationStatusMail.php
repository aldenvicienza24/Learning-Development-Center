<?php

namespace App\Mail;

use App\Models\Registration;
use App\Models\WebsiteSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $opening;
    public string $closing;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Registration $registration,
        public string $status
    ) {
        $this->buildContent();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->status === 'diterima'
            ? 'Konfirmasi Pendaftaran Disetujui'
            : 'Informasi Status Pendaftaran';

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.registration-status',
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

    private function buildContent(): void
    {
        $prefix = $this->status === 'diterima' ? 'email_approved' : 'email_rejected';
        
        $rawOpening = WebsiteSetting::getValue("{$prefix}_opening", '');
        $rawClosing = WebsiteSetting::getValue("{$prefix}_closing", '');

        $programTitle = $this->registration->program?->title ?? 'Program';

        $replacements = [
            '{nama}' => $this->registration->full_name,
            '{program}' => $programTitle,
            '{institusi}' => $this->registration->institution,
        ];

        $this->opening = strtr($rawOpening, $replacements);
        $this->closing = strtr($rawClosing, $replacements);
    }
    
    public function hasContent(): bool
    {
        return !empty(trim($this->opening)) || !empty(trim($this->closing));
    }
}
