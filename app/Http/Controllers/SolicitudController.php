<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSolicitudRequest;
use App\Http\Requests\UpdateSolicitudRequest;
use App\Http\Resources\SolicitudResource;
use App\Models\Solicitud;
use Illuminate\Support\Facades\Gate;

class SolicitudController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Solicitud::class);

        $solicitudes = Solicitud::with('sesion', 'solicitante', 'descripcion')->get();

        return SolicitudResource::collection($solicitudes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSolicitudRequest $request)
    {
        Gate::authorize('create', Solicitud::class);

        $solicitud = new Solicitud();

        $solicitud->ASUNTO                      = $request->input('asunto');
        $solicitud->DESICION                    = $request->input('desicion');
        $solicitud->FECHA_DE_SOLICITUD          = $request->input('fecha_solicitud');
        $solicitud->DEPENDENCIA                 = $request->input('dependencia');
        $solicitud->SOLICITANTE_IDSOLICITANTE   = $request->input('solicitante_id');
        $solicitud->SESION_IDSESION             = $request->input('sesion_id');
        $solicitud->DESCRIPCION_IDDESCRIPCION   = $request->input('descripcion_id');

        $solicitud->save();

        return new SolicitudResource($solicitud);
    }

    /**
     * Display the specified resource.
     */
    public function show(Solicitud $solicitude)
    {
        Gate::authorize('view', $solicitude);

        $solicitude->load('solicitante', 'descripcion');

        return new SolicitudResource($solicitude);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSolicitudRequest $request, Solicitud $solicitud)
    {
        Gate::authorize('update', $solicitud);

        $solicitud->ASUNTO                      = $request->input('asunto');
        $solicitud->DESICION                    = $request->input('desicion');
        $solicitud->FECHA_DE_SOLICITUD          = $request->input('fecha_solicitud');
        $solicitud->DEPENDENCIA                 = $request->input('dependencia');
        $solicitud->SOLICITANTE_IDSOLICITANTE   = $request->input('solicitante_id');
        $solicitud->SESION_IDSESION             = $request->input('sesion_id');
        $solicitud->DESCRIPCION_IDDESCRIPCION   = $request->input('descripcion_id');

        $solicitud->save();

        return response()->json(['data' => new SolicitudResource($solicitud)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Solicitud $solicitude)
    {
        Gate::authorize('update', $solicitude);

        $solicitude->delete();

        return response()->noContent();
    }
}
