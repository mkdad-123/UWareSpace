<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public $name;

    public function __construct($code,$name)
    {
        $this->code = $code;
        $this->name = $name;
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send Email Verification',
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'emails.adminVerification' ,
            with:[
                'name' => $this->name,
                'code' => $this->code
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
