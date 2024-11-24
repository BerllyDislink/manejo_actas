<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSolicitanteRequest;
use App\Http\Resources\SolicitanteResource;
use App\Models\Solicitante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SolicitanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Solicitante::class);

        $solicitantes = QueryBuilder::for(Solicitante::class)
            ->allowedFilters([
                AllowedFilter::partial('nombre', 'NOMBRE'),
                AllowedFilter::exact('email', 'EMAIL'),
            AllowedFilter::exact('celular', 'CELULAR'),
            ])->get();

        return SolicitanteResource::collection($solicitantes);
    } 

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSolicitanteRequest $request)
    {
        Gate::authorize('create', Solicitante::class);

        $solicitante = new Solicitante();

        $solicitante->NOMBRE                = $request->input('nombre');
        $solicitante->TIPO_DE_SOLICITANTE   = $request->input('tipo_solicitante');
        $solicitante->EMAIL                 = $request->input('email');
        $solicitante->CELULAR               = $request->input('celular');

        $solicitante->save();

        return new SolicitanteResource($solicitante);
    }

    /**
     * Display the specified resource.
     */
    public function show(Solicitante $solicitante)
    {
        Gate::authorize('view', $solicitante);

        return new SolicitanteResource($solicitante);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Solicitante $solicitante)
    {
        Gate::authorize('update', $solicitante);

        $solicitante->NOMBRE                = $request->input('nombre');
        $solicitante->TIPO_DE_SOLICITANTE   = $request->input('tipo_solicitante');
        $solicitante->EMAIL                 = $request->input('email');
        $solicitante->CELULAR               = $request->input('celular');

        $solicitante->save();

        return response()->json(['data' => new SolicitanteResource($solicitante)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Solicitante $solicitante)
    {
        Gate::authorize('delete', $solicitante);

        $solicitante->delete();

        return response()->noContent();
    }


}
