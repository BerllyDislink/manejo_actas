<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use App\Http\Resources\proposicionResource;
use App\Models\Proposicione;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class proposicionesController extends Controller
{
    // para obtener los datos de sesion
public function index() {
    try {
        $this->authorize('viewAny', Proposicione::class);

        // Cargar las relaciones correctamente
        $proposiciones = Proposicione::with(['sesion'])->orderByDesc('ID_PROPOSICIONES')->paginate(6);

        return response()->json(ProposicionResource::collection($proposiciones), 200);
    } catch (Exception | AuthorizationException $e) {
        return response()->json([
            'message' => 'Error al consultar las proposiciones',
            'error' => $e->getMessage()
        ], 500); // Cambié el código de error a 500 para capturar errores de servidor
    }
}




    //para almancear las sesiones

    public function store(Request $request){

        try {
            $this->authorize('create', Proposicione::class);

            $validator = Validator::make($request->all(), [
                'DESCRIPCION' => 'required',
                'DESICION' => 'required',
                'MIEMBRO_IDMIEMBRO' => 'required',
                'SESION_IDSESION' => 'required'
            ]);
            if ($validator->fails()) {
                $data = [
                    'message' => 'Error en la validación de los datos',
                    'errors' => $validator->errors(),
                    'status' => 400
                ];
                return response()->json($data, 400);
            }
            $proposiciones = Proposicione::create([
                'DESCRIPCION' => $request->DESCRIPCION,
                'DESICION' => $request->DESICION,
                'MIEMBRO_IDMIEMBRO' => $request->MIEMBRO_IDMIEMBRO,
                'SESION_IDSESION' => $request->SESION_IDSESION
            ]);
            if (!$proposiciones) {
                $data = [
                    'message' => 'Error al crear sesion',
                    'status' => 500
                ];
                return response()->json($data, 500);
            }
            $data = [
                'proposiciones' => $proposiciones,
                'status' => 201
            ];
            return response()->json($data, 201);

        }catch (Exception | AuthenticationException $e){
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function show($ID_PROPOSICIONES){

        try {
            $this->authorize('view', Proposicione::class);

            $proposiciones = Proposicione::find($ID_PROPOSICIONES);
            if (!$proposiciones) {
                $data = [
                    'message' => 'proposición no encontrada',
                    'status' => 404
                ];
                return response()->json($data, 404);
            }
            $data = [
                'proposiciones' => $proposiciones,
                'status' => 200
            ];
            return response()->json($data, 200);
        }catch (Exception | AuthenticationException $e){
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function delete($ID_PROPOSICIONES)
    {
        try {

            $this->authorize('delete', Proposicione::class);

            $proposiciones = Proposicione::find($ID_PROPOSICIONES);

            if (!$proposiciones) {
                return response()->json([
                    'message' => 'Proposición no encontrada',
                    'status' => 404
                ], 404);
            }

            $proposiciones->delete();

            return response()->json([
                'message' => 'Proposición eliminada',
                'status' => 200
            ], 200);
        }catch (Exception | AuthenticationException $e){
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }



    public function update(Request $request, $ID_PROPOSICIONES){
        try {
            $this->authorize('update', Proposicione::class);
            $proposiciones = Proposicione::find($ID_PROPOSICIONES);
            if(!$proposiciones){
                $data = [
                    'message' => 'Proposición no encontrada',
                    'status' => 404
                ];
                return response()->json($data,404);
            }
            $validator = Validator::make($request->all(),[
                'DESCRIPCION' => 'required',
                'DESICION' => 'required',
                'MIEMBRO_IDMIEMBRO' => 'required',
                'SESION_IDSESION' => 'required'
            ]);
            if($validator->fails()){
                $data = [
                    'message' => 'Error en la validación de los datos',
                    'errors' => $validator->errors(),
                    'status' => 400
                ];
                return response()->json($data,400);

            }
            $proposiciones->DESCRIPCION = $request ->DESCRIPCION;
            $proposiciones->DESICION = $request ->DESICION;
            $proposiciones->MIEMBRO_IDMIEMBRO = $request->MIEMBRO_IDMIEMBRO;
            $proposiciones->SESION_IDSESION = $request->SESION_IDSESION;

            $proposiciones->save();

            $data = [
                'message' => 'Proposición actualizada',
                'proposiciones' => $proposiciones,
                'status' => 200
            ];
            return response()->json($data,200);
        }catch (Exception | AuthenticationException $e){
            return response()->json(['error' => $e->getMessage()], 401);
        }

    }

    public function deleteByIdSesion ($IDSESION)
    {
        try {
            Gate::authorize('delete', Proposicione::class);
            $proposicion = Proposicione::where('SESION_IDSESION', '=', $IDSESION);
            $proposicion->delete();
            return response()->json(['message'=>'proposicion eliminada correactamente'], 200);
        }catch (Exception $e){
            return response()->json(['message' => 'No fue posible eliminar la propocision de esta sesion', 'description' => $e->getMessage() ], 404);
        }
    }
    public function actualizarDecision(Request $request, $ID_PROPOSICIONES)
{
    // Validar que el ID es válido
    if ($ID_PROPOSICIONES <= 0) {
        return response()->json(['message' => 'El ID de la proposición debe ser mayor que 0'], 404);
    }

    // Validar el campo 'DECISION'
    $validatedData = $request->validate([
        'DESICION' => 'required|in:aprobada,rechazada,pendiente'
    ]);

    try {
        // Autorizar la acción
        $this->authorize('update', Proposicione::class);

        // Buscar la proposición por ID
        $proposicion = Proposicione::find($ID_PROPOSICIONES);

        if (!$proposicion) {
            return response()->json([
                'message' => 'Proposición no encontrada',
                'status' => 404
            ], 404);
        }

        // Actualizar el campo 'DECISION'
        $proposicion->DESICION = $validatedData['DESICION'];
        $proposicion->save();

        return response()->json([
            'message' => 'La decisión de la proposición ha sido actualizada correctamente.',
            'proposicion' => $proposicion,
            'status' => 200
        ], 200);

    } catch (Exception $e) {
        return response()->json([
            'message' => 'No se encontró la proposición o hubo un error al actualizar la decisión.',
            'error' => $e->getMessage()
        ], 500); // Error interno del servidor
    }
}

public function getProposicionesBySesion($IDSESION)
{
    try {
        // Autorizar la acción
        Gate::authorize('view', Proposicione::class);

        // Cargar las relaciones 'miembro.users' y 'sesion'
        $proposiciones = Proposicione::with(['miembro.users', 'sesion'])
            ->where('SESION_IDSESION', '=', $IDSESION)
            ->orderByDesc('ID_PROPOSICIONES')
            ->paginate(4);

        // Verificar si no hay proposiciones para esa sesión
        if ($proposiciones->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron proposiciones para esta sesión'
            ], 404);
        }

        // Retornar los datos con el recurso
        return response()->json($proposiciones, 200);
    } catch (Exception | AuthorizationException $e) {
        return response()->json([
            'message' => 'Error al consultar las proposiciones',
            'error' => $e->getMessage()
        ], 500);
    }
}




}
