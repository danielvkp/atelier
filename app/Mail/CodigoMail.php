<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CodigoMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $codigo;

    public function __construct($codigo){
      $this->codigo = $codigo;
    }


    public function envelope(): Envelope{
        return new Envelope(
            subject: 'Restablecer contraseña',
        );
    }

    public function content(): Content{
        return new Content(
            markdown: 'mails.recover_password',
            with:[
              'codigo' => $this->codigo
            ]
        );
    }


    public function attachments(): array{
        return [];
    }
}
