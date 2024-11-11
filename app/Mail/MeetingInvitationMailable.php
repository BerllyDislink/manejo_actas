<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MeetingInvitationMailable extends Mailable
{
    use Queueable, SerializesModels;
    private $invitado;
    private $subjetc;
    private $sesion;
    /**
     * Create a new message instance.
     */
    public function __construct($invitado, $sesion, $subjetc)
    {
        $this->invitado = $invitado;
        $this->subjetc = $subjetc;
        $this->sesion = $sesion;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjetc,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.meeting-invitation',
            with: [
                'nombre' => $this->invitado['NOMBRE'],
                'lugar' => $this->sesion['LUGAR'],
                'fecha' => $this->sesion['FECHA'],
                'hora' => $this->sesion['HORARIO_INICIO'],
                'presidente' => $this->sesion['PRESIDENTE'],
                'secretario' => $this->sesion['SECRETARIO']
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
