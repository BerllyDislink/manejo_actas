<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateActaRequest;
use App\Http\Requests\UpdateActRequest;
use App\Http\Resources\ActaResource;
use App\Models\Acta;
use http\Message;
use Illuminate\Http\Request;
use Mockery\Exception;

class ActaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actas = Acta::all();
        return response()->json(ActaResource::Collection($actas),200);
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
            $createActa = Acta::create($request->validated());
            return response()->json($createActa,201);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error al crear el acta',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if($id < 0){
            return response()->json(['message'=>'id debe ser mayor que 0'],404);
        }

        try{
            $acta = Acta::with('sesion')->findOrFail($id);
            return response()->json(new ActaResource($acta),200);

        }catch (\Exception $e){
            return response()->json([
                'Message' => "No se encontro el acta",
                'Error' => $e->getMessage()
            ], 404);
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
            return response()->json(['error' => 'id del acta a actualizar debe ser mayor que 0'],404);
        }

        try{
            $acta = Acta::findOrFail($id);
            $acta->Update($request->validated());
            return response()->json($acta,200);
        }catch (Exception $e){
            return response()->json(['Message' => "No se encontro el acta"],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if($id < 0){
            return response()->json(['message'=>'id del acta a actualizar debe ser mayor que 0'],404);
        }

        try{
            $acta = Acta::findOrFail($id);
            $acta->delete();
            return response()->json(['data' => 'El acta con el id: '.$id. ' ha sido eliminada'],200);
        }catch (Exception $e){
            return response()->json(['message' => "No se encontro el acta"],404);
        }
    }
    public function aprobarActaAnterior(Request $request, $id)
{
    if ($id < 0) {
        return response()->json(['message' => 'El id del acta debe ser mayor que 0'], 404);
    }

    // Validar el estado solicitado
    $validatedData = $request->validated([
        'estado' => 'required|in:aprobada,rechazada,pendiente'
    ]);

    try {
        // Buscar el acta por id
        $acta = Acta::findOrFail($id);

        // Actualizar el estado del acta
        $acta->Update = $validatedData['estado'];
        return response()->json([
            'mensaje' => 'El estado del acta ha sido actualizado correctamente.',
            'acta' => $acta
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'mensaje' => 'No se encontró el acta o hubo un error al actualizar el estado.',
            'error' => $e->getMessage()
        ], 404);
    }
}
}
