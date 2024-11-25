<?php

namespace App\Listeners;

use App\Events\ApplicationUpdated;
use App\Http\Resources\SolicitudResource;
use App\Mail\ApplicationUpdate;
use App\Models\Solicitud;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendApplicationUpdateEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ApplicationUpdated $event): void
    {
        $application = Solicitud::with('sesion', 'solicitante')
            ->find($event->applicationId);

        
        if (!$application || !$application->solicitante || !$application->solicitante->EMAIL) {
            Log::error('Solicitud o correo del solicitante no encontrado', ['applicationId' => $event->applicationId]);
            return;
        }

        
        Log::info('Enviando correo para la solicitud', ['application' => $application]);

        
        Mail::to($application->solicitante->EMAIL)
            ->send(new ApplicationUpdate(new SolicitudResource($application), $event->subject));


       /*  Log::info('enviando mail', [$applicationId]);

        Mail::to($application->solicitante->EMAIL)
            ->send(new ApplicationUpdate(new SolicitudResource($application), $this->subject)); */
    }
}
