<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendJobEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $role;
    public $password;

    public function __construct($name,$role,$password)
    {
        $this->password = $password;
        $this->role = $role;
        $this->name = $name;
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send Job Email',
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'emails.EmployeeJob',
            with: [
                'name' => $this->name,
                'role' => $this->role,
                'password' => $this->password
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
