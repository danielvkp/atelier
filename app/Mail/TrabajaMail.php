<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Attachment;

class TrabajaMail extends Mailable
{
  public $data;

  public function __construct($data){
    $this->data = $data;
  }

  public function envelope(): Envelope{
      return new Envelope(
          subject: 'Contacto WEB',
      );
  }

  /**
   * Get the message content definition.
   */
  public function content(): Content
  {
      return new Content(
          markdown: 'mail.trabaja_section',
      );
  }

  public function attachments(): array{
    if($this->data['cv_file']){
        return [
           Attachment::fromData(
              fn () => $this->data['cv_file']->get(),
              $this->data['cv_file']->getClientOriginalName(),
              ['mime' => $this->data['cv_file']->getMimeType()]
           ),
        ];
     }
     return [];
  }
}
