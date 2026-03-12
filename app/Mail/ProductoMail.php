<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class ProductoMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $archivo_url;

    public $orden;

    public string $nombre;

    public function __construct(string $archivo_url, $orden, string $nombre){
      $this->archivo_url = $archivo_url;
      $this->orden = $orden;
      $this->nombre = $nombre;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recibo de tu compra',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.producto_mail',
            with:[
              'orden'  => $this->orden,
              'nombre' => $this->nombre
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
        return [
          Attachment::fromStorageDisk('pdf', $this->archivo_url)
          ->as($this->archivo_url)
          ->withMime('application/pdf'),
        ];
    }
}
