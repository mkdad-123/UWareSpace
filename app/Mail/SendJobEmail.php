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
    public $admin;

    public function __construct($name,$role,$password,$admin)
    {
        $this->password = $password;
        $this->role = $role;
        $this->name = $name;
        $this->admin = $admin;
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recruitment Email',
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'emails.EmployeeJob',
            with: [
                'name' => $this->name,
                'role' => $this->role,
                'password' => $this->password,
                'adminPhone' => $this->admin->phone,
                'adminName' => $this->admin->name,
                'adminEmail' => $this->admin->email,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
