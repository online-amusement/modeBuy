<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class Registration extends Mailable
{
    use Queueable, SerializesModels;

    protected $temporaryRegistration;

    /**
     * Create a new message instance.
     */
    public function __construct($temporaryRegistration)
    {
        $this->temporaryRegistration = $temporaryRegistration;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(env('MAIL_FROM_ADDRESS')),
            subject: '下記URLクリック後にパスワードを発行します',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.temporaryRegistration',
            with:[
                'token' => $this->temporaryRegistration->token
            ],
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
