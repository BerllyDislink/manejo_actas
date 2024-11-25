<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAsistenciaMiembroRequest;
use App\Http\Requests\UpdateAsistenciaRequest;
use App\Http\Resources\AsistenciaMiembroResource;
use App\Mail\MeetingInvitationMailable;
use App\Models\AsistenciaMiembro;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Spatie\QueryBuilder\QueryBuilder;

class AsistenciaMiembrosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', AsistenciaMiembro::class);
        $AsistenciaMiembros = AsistenciaMiembro::all();
        return response()->json(AsistenciaMiembroResource::Collection($AsistenciaMiembros));
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
    public function store(CreateAsistenciaMiembroRequest $request)
    {
        Gate::authorize('create', AsistenciaMiembro::class);

        $validatedRequest = $request->validated();

        try {

            $listMiembros = QueryBuilder::for(User::class)
                ->select('users.id', 'miembros.IDMIEMBRO as id_miembro' ,'users.email', 'miembros.NOMBRE', 'miembros.CARGO', 'roles.name as rol')
                ->join('miembros', 'users.id', '=', 'miembros.user_id')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->get();

            DB::transaction(function () use ($validatedRequest, $listMiembros) {
                collect($listMiembros)->map(function ($miembro) use ($validatedRequest) {


                    $newAsistenciaMiembro = new AsistenciaMiembro();
                    $newAsistenciaMiembro->SESSION_IDSESION = $validatedRequest['idSesion'];
                    $newAsistenciaMiembro->MIEMBRO_IDMIEMBRO = $miembro["id_miembro"];
                    $newAsistenciaMiembro->ESTADO_ASISTENCIA = 'Pendiente';
                    $newAsistenciaMiembro->save();

                    $email = $newAsistenciaMiembro->miembro()->with('users')->get()->pluck('users.email');
                    $miembro = $newAsistenciaMiembro->miembro()->get();
                    $sesion = $newAsistenciaMiembro->sesion()->get();

                    Mail::to($email[0])->send(new MeetingInvitationMailable($miembro[0], $sesion[0], 'Invitacion a reunion'));
                });

            });

            return response()->json(['message' => 'Invitaciones asignadas (Miembros)'], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error al enviar las invitaciones', 'description' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

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
    public function update(UpdateAsistenciaRequest $request, $idSesion, $idMiembro)
    {
        try {
            Gate::authorize('update', AsistenciaMiembro::class);
            $validatedRequest = $request->validated();

            $asistenciaMiembro = AsistenciaMiembro::where('SESSION_IDSESION', '=', $idSesion)
                ->where('MIEMBRO_IDMIEMBRO', '=', $idMiembro);

            $asistenciaMiembro->update([
                'ESTADO_ASISTENCIA' => $validatedRequest['estadoAsistencia']
            ]);

            return response()->json(['message' => 'Asistencia actualizada correctamente'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'No se pudo actualizar la asistencia', 'description' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idSesion, $idMiembro)
    {
        try {
            Gate::authorize('delete', AsistenciaMiembro::class);
            $asistenciaMiembro = AsistenciaMiembro::where('SESSION_IDSESION', '=', $idSesion)
                ->where('MIEMBRO_IDMIEMBRO', '=', $idMiembro);

            $asistenciaMiembro->delete();

            return response()->json(['message' => 'Asistencia eliminada correctamente'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'No se pudo eliminar la asistencia', 'description' => $e->getMessage()], 400);
        }
    }


    public function deleteByIdSesion($idSesion)
    {
        try {
            Gate::authorize('delete', AsistenciaMiembro::class);
            $asistenciaMiembro = AsistenciaMiembro::where('SESSION_IDSESION', '=', $idSesion);

            $asistenciaMiembro->delete();

            return response()->json(['message' => 'Asistencia eliminada correctamente'], 200);
        }catch (Exception $e){
            return response()->json(['message' => 'No se pudo eliminar la asistencia', 'description' => $e->getMessage()], 404);
        }
    }


}
