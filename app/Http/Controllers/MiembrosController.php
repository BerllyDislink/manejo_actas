<?php

namespace App\Http\Controllers;

use App\Models\Miembro;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\QueryBuilder;

class MiembrosController extends Controller
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
    public function store(Request $request)
    {
        //
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

    }

    // obtengo la informaccion mas completa de los miembros mas el usuario y el rol
    public function getMiembros()
    {
        Gate::authorize('view', Miembro::class);

        $miembros = QueryBuilder::for(User::class)
            ->select('users.id', 'miembros.IDMIEMBRO as id_miembro' ,'users.email', 'miembros.NOMBRE', 'miembros.CARGO', 'roles.name as rol')
            ->join('miembros', 'users.id', '=', 'miembros.user_id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->get();
        return response()->json($miembros);
    }
}
