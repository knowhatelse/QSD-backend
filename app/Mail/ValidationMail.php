<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ValidationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $validationKey;

    /**
     * Create a new message instance.
     */
    public function __construct($validationKey)
    {
        $this->validationKey=$validationKey;
    }

    /**
     * Get the message envelope.
     * @return $this
     */
    public function build(){
        return $this->view('emails.validation')
            ->subject('Validation Key for Login')
            ->with([
                'validationKey' => $this->validationKey
            ]);
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Validation Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.validation',
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
