<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAsistenciaInvitadoRequest;
use App\Http\Requests\CreateAsistenciaMiembroRequest;
use App\Models\AsistenciaInvitado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

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

        DB::transaction(function () use ($validatedData){
            collect($validatedData['listInvitados'])->map(function ($invitado) use ($validatedData) {
                AsistenciaInvitado::create([
                    'INIVITADO_IDINVITADO' => $invitado['id_invitado'],
                    'SESION_IDSESION' => $validatedData['idSesion'],
                    'ESTADO_ASISTENCIA' => 'Pendiente'
                ]);
            });
        });

        return response()->json(['message' => 'Invitaciones asignadas (Invitados)']);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
