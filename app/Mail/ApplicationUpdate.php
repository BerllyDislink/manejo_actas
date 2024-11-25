<?php

namespace App\Mail;

use App\Http\Resources\SolicitudResource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ApplicationUpdate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public SolicitudResource $application,
        public $subject,
    )
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */

     /* 
     {
            "id": 2,
            "dependencia": "juan",
            "asunto": "aprovaci\u00f3n de homologaci\u00f3n",
            "desicion": "aprobada",
            "fecha_solicitud": "2024-11-22T00:00:00.000000Z",
            "sesion_id": 1,
            "solicitante_id": 1,
            "descripcion_id": 13,
            "sesion": {
                "id": 1,
                "lugar": "centro de convencion",
                "fecha": "2024-11-11",
                "hora_inicio": "2024-11-25 04:46:00",
                "hora_final": "2024-11-24 19:00:00",
                "presidente": "pedro perez",
                "secretario": "pedro perez"
            },
            "solicitante": {
                "id": 1,
                "nombre": "Javier Montes",
                "tipo_solicitante": "estudiante",
                "email": "javier@correo.com",
                "celular": "3012489928"
            },

        }
     */

    public function content(): Content
    {
        return new Content(
            view: 'mail.application-update',
            with: [
                'application' => $this->application
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
