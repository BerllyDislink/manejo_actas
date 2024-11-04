<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use App\Models\Proposicione;
use Illuminate\Support\Facades\Validator;

class proposicionesController extends Controller
{
    // para obtener los datos de sesion
    public function index(){

        try {
            $this->authorize('viewAny', Proposicione::class);

            $proposiciones = Proposicione::all();
            $data = [
                'proposiciones' => $proposiciones,
                'status' => 200
            ];
            return response()->json($data, 200);
        }catch (Exception | AuthenticationException $e){
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    //para almancear las sesiones

    public function store(Request $request){

        try {
            $this->authorize('create', Proposicione::class);

            $validator = Validator::make($request->all(), [
                'DESCRIPCION' => 'required',
                'DECISION' => 'required',
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
                'DECISION' => $request->DECISION,
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
                'DECISION' => 'required',
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
            $proposiciones->DECISION = $request ->DECISION;
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

}
