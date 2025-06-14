<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAsistenciaInvitadoRequest;
use App\Http\Requests\UpdateAsistenciaRequest;
use App\Mail\MeetingInvitationMailable;
use App\Models\AsistenciaInvitado;
use \Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class AsistenciaInvitadosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAsistenciaInvitadoRequest $request)
    {
        Gate::authorize('create', AsistenciaInvitado::class);
        $validatedData = $request->validated();

        try {
            DB::transaction(function () use ($validatedData) {
                collect($validatedData['listInvitados'])->map(function ($invitado) use ($validatedData) {

                    $existGuest = AsistenciaInvitado::where('INIVITADO_IDINVITADO', $invitado['id_invitado'])
                        ->where('SESION_IDSESION', $validatedData['idSesion'])
                        ->exists();

                    if($existGuest) {
                        throw new \Exception($invitado['NOMBRE']." ya ha sido invitado");
                    }

                    $newAsistenciaInvitado = new AsistenciaInvitado();
                    $newAsistenciaInvitado->SESION_IDSESION = $validatedData['idSesion'];
                    $newAsistenciaInvitado->INIVITADO_IDINVITADO = $invitado['id_invitado'];
                    $newAsistenciaInvitado->ESTADO_ASISTENCIA = 'Pendiente';
                    $newAsistenciaInvitado->save();

                    $invitado = $newAsistenciaInvitado->invitado()->get();
                    $sesion = $newAsistenciaInvitado->sesion()->get();
                    $email = $newAsistenciaInvitado->invitado()->with('users')->get()->pluck('users.email');

                    Mail::to($email[0])->send(new MeetingInvitationMailable($invitado[0], $sesion[0], "Invitacion a reunion"));
                });
            });
            return response()->json(['message' => 'Invitaciones asignadas (Invitados)']);
        }catch (Exception $e ){
            return response()->json(['message' => 'Error al enviar las invitaciones', 'description' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAsistenciaRequest $request, $idSesion, $idInvitado)
    {
        try {
            Gate::authorize('update', AsistenciaInvitado::class);
            $validatedRequest = $request->validated();
            $asistenciaInvitado = AsistenciaInvitado::where('SESION_IDSESION', '=', $idSesion)
            ->where('INIVITADO_IDINVITADO' , '=', $idInvitado);

            $asistenciaInvitado->update([
                'ESTADO_ASISTENCIA' => $validatedRequest['estadoAsistencia']
            ]);

            return response()->json(['message' => 'Asistencia actualizada correctamente'], 200);
        }catch (Exception $e){
            return response()->json(['message' => 'No actualizar la asistencia', 'description' => $e->getMessage()]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idSesion, $idInvitado)
    {
        try{
            Gate::authorize('delete', AsistenciaInvitado::class);

            $asistenciaInvitado = AsistenciaInvitado::where('SESION_IDSESION', '=', $idSesion)
                ->where('INIVITADO_IDINVITADO' , '=', $idInvitado);

            $asistenciaInvitado->delete();

            return response()->json(['message' => 'Asistencia eliminada correctamente']);

        }catch (Exception $e){
            return response()->json(['message' => 'No se pudo eliminar la asistencia', 'description' => $e->getMessage()]);
        }

    }

    public function deleteByIdSesion($idSesion)
    {
        try{
            Gate::authorize('delete', AsistenciaInvitado::class);

            $asistenciaInvitado = AsistenciaInvitado::where('SESION_IDSESION', '=', $idSesion);

            $asistenciaInvitado->delete();

            return response()->json(['message' => 'Asistencia eliminada correctamente']);

        }catch (Exception $e){
            return response()->json(['message' => 'No se pudo eliminar la asistencia', 'description' => $e->getMessage()],404);
        }

    }
}
