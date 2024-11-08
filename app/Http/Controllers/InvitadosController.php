<?php

namespace App\Http\Controllers;

use App\Models\Invitado;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\QueryBuilder;

class InvitadosController extends Controller
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
        //
    }

    public function getInvitadosWithOutStudentsRole (): \Illuminate\Http\JsonResponse
    {
        Gate::authorize('view', Invitado::class);

        $invitadosWhitOutStudents = QueryBuilder::for(User::class)
            ->select('users.id', 'invitados.IDINVITADOS as id_invitado', 'users.email', 'invitados.NOMBRE', 'invitados.CARGO', 'roles.name as rol')
            ->join('invitados', 'users.id', '=', 'invitados.user_id')
            ->join('model_has_roles' , 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('roles.name', '!=', 'estudiante')
            ->get();

        return response()->json($invitadosWhitOutStudents);
    }
}
