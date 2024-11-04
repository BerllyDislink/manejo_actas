<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDescripcionRequest;
use App\Http\Requests\UpdateDescripcionRequest;
use App\Http\Resources\DescripcionResource;
use App\Models\Descripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DescripcionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Descripcion::class);

        $descripciones = Descripcion::all();

        return DescripcionResource::collection($descripciones);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDescripcionRequest $request)
    {
        Gate::authorize('create', Descripcion::class);

        $descripcion = new Descripcion();

        $descripcion->ESTU_IMPLICADOS       = $request->input('estudiantes');
        $descripcion->NUM_ESTU_IMPLICADOS   = $request->input('numero_estudiantes');
        $descripcion->DOCEN_IMPLICADOS      = $request->input('docentes');
        $descripcion->NUM_DOCEN_IMPLICADOS  = $request->input('numero_docentes');
        $descripcion->CIUDAD_IMPLICADA      = $request->input('ciudad');
        $descripcion->PAIS_IMPLICADO        = $request->input('pais');
        $descripcion->EVENTO                = $request->input('evento');

        $descripcion->save();
        
        return new DescripcionResource($descripcion);
    }

    /**
     * Display the specified resource.
     */
    public function show(Descripcion $descripcione)
    {
        Gate::authorize('view', $descripcione);

        return new DescripcionResource($descripcione);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDescripcionRequest $request, Descripcion $descripcione)
    {
        Gate::authorize('update', $descripcione);

        $descripcione->ESTU_IMPLICADOS       = $request->input('estudiantes');
        $descripcione->NUM_ESTU_IMPLICADOS   = $request->input('numero_estudiantes');
        $descripcione->DOCEN_IMPLICADOS      = $request->input('docentes');
        $descripcione->NUM_DOCEN_IMPLICADOS  = $request->input('numero_docentes');
        $descripcione->CIUDAD_IMPLICADA      = $request->input('ciudad');
        $descripcione->PAIS_IMPLICADO        = $request->input('pais');
        $descripcione->EVENTO                = $request->input('evento');

        $descripcione->save();
        
        return response()->json([ 'data' => new DescripcionResource($descripcione)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Descripcion $descripcione)
    {
        Gate::authorize('update', $descripcione);
        
        $descripcione->delete();

        return response()->noContent();
    }
}
