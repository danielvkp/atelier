<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Orden;

class OrdenMail extends Mailable
{
    use Queueable, SerializesModels;

    public $orden;

    public function __construct(Orden $orden){
      $this->orden = $orden;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Información de tu reserva',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
      return new Content(
          markdown: 'mail.orden_mail',
          with: [
            'orden' => $this->orden,
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
