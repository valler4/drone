<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($mydata)
    {
        $this->data = $mydata;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mail Email',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.emailotp',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
