<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistroMail extends Mailable
{
    use Queueable, SerializesModels;

    public $password;
    public $name;
    public $email;

    public function __construct($name, $email, $password){
      $this->password = $password;
      $this->email = $email;
      $this->name = $name;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Acceso plataforma',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mails.nuevo_usuario',
            with:[
              'name'     => $this->name,
              'email'    => $this->email,
              'password' => $this->password
             ]
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
