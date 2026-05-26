<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;
    // Public properties are automatically exposed inside your mail view
    public array $formData;

    public function __construct(array $formData)
    {
        $this->formData = $formData;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Message via Contact Form: ' . ($this->formData['subject'] ?? 'No Subject'),
            replyTo: [$this->formData['email']]
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-form-submitted',
        );
    }
}
