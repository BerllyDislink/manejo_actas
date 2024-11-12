<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateActaRequest;
use App\Http\Requests\UpdateActRequest;
use App\Http\Resources\ActaResource;
use App\Models\Acta;
use http\Message;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Mockery\Exception;

class ActaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $this->authorize('viewAny', acta::class);

            $actas = Acta::all();
            return response()->json(ActaResource::Collection($actas),200);
        }catch (Exception | AuthorizationException $e){
            return response()->json([
                'message' => 'Error al consultar las actas',
                'error' => $e->getMessage()
            ], 401);
        }
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
    public function store(CreateActaRequest $request): \Illuminate\Http\JsonResponse
    {

        try {
            $this->authorize('create', acta::class);

            $createActa = Acta::create($request->validated());
            return response()->json(['message' => 'Acta '.$createActa['ID_ACTA'].' creada correctamente: ', $createActa],201);
        } catch (Exception | AuthorizationException $e) {

            return response()->json([
                'message' => 'Error al crear el acta',
                'error' => $e->getMessage()
            ], 401);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if($id < 0){
            return response()->json(['message'=>'id debe ser mayor que 0', 'error' => ''],404);
        }

        try{
            $this->authorize('view', acta::class);

            $acta = Acta::with('sesion')->findOrFail($id);
            return response()->json(new ActaResource($acta),200);

        }catch (Exception |AuthorizationException $e){
            return response()->json([
                'Message' => "Error al mostrar el acta",
                'Error' => $e->getMessage()
            ], 401);
        }
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
    public function update(UpdateActRequest $request,  $id)
    {
        if($id < 0){
            return response()->json(['Message' => 'id del acta a actualizar debe ser mayor que 0'
            ,'error' => ''],404);
        }

        try{
            $this->authorize('update', acta::class);
            $acta = Acta::findOrFail($id);
            $acta->Update($request->validated());
            return response()->json($acta,200);
        }catch (Exception | AuthorizationException $e){
            return response()->json(['Message' => "Error al actualizar el acta", 'error' => $e], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if($id < 0){
            return response()->json(['message'=>'id del acta a actualizar debe ser mayor que 0'
            , 'error' => ''],404);
        }

        try{
            $this->authorize('delete', acta::class);
            $acta = Acta::findOrFail($id);
            $acta->delete();
            return response()->json(['data' => 'El acta con el id: '.$id. ' ha sido eliminada'],200);
        }catch (Exception | AuthorizationException $e){
            return response()->json(['Message' => "Error al eliminar el acta", 'error' => $e],401);
        }
    }
    public function aprobarActaAnterior(Request $request, $id)
    {
        // Check if id is valid
        if ($id <= 0) {
            return response()->json(['message' => 'El id del acta debe ser mayor que 0'], 404);
        }

        // Validate the 'estado' field
        $validatedData = $request->validate([
            'estado' => 'required|in:aprobada,rechazada,pendiente'
        ]);

        try {
            // Find the acta by id
            $acta = Acta::findOrFail($id);

            // Update the estado property on the acta model
            $acta->estado = $validatedData['estado'];
            $acta->save();

            return response()->json([
                'mensaje' => 'El estado del acta ha sido actualizado correctamente.',
                'acta' => $acta
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'No se encontró el acta o hubo un error al actualizar el estado.',
                'error' => $e->getMessage()
            ], 404);  // Use 500 for server error
        }
    }

}
