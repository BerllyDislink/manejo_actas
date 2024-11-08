<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAsistenciaMiembroRequest;
use App\Http\Resources\AsistenciaMiembroResource;
use App\Models\AsistenciaMiembro;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

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

            DB::transaction(function () use ($validatedRequest) {
                collect($validatedRequest['listMiembros'])->map(function ($miembro) use ($validatedRequest) {

                    return AsistenciaMiembro::create(
                        [
                            "SESSION_IDSESION" => $validatedRequest['idSesion'],
                            "MIEMBRO_IDMIEMBRO" => $miembro["id_miembro"],
                            "ESTADO_ASISTENCIA" => 'pendiente'
                        ]
                    );
                });
            });
            return response()->json(['message' => 'Invitaciones asignadas (Miembros)'], 201);
        }catch (Exception $e){
            return response()->json(['message' => $e->getMessage()], 400);
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
