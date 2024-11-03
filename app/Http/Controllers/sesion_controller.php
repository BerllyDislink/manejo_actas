<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use App\Models\Sesion;
use App\Models\acta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;
use function Laravel\Prompts\error;

class sesion_controller extends Controller
{

    // para obtener los datos de sesion
    public function index(){

        try{

            $this->authorize('viewAny', Sesion::class);

            $sesion = Sesion::all();
            $data = [
                'sesion' => $sesion,
                'status' => 200
            ];
            return response()->json($data,200);
        }catch (Exception | AuthorizationException $e){
            return response()->json(['error' => $e->getMessage()]);
        }

    }

    //para almancear las sesiones

    public function store(Request $request){

        try {

            $this->authorize('create', Sesion::class);

            $validator = Validator::make($request->all(),[
                'LUGAR' => 'required',
                'FECHA' => 'required|date',
                'HORARIO_INICIO' => 'required|date_format:H:i',
                'HORARIO_FINAL' => 'required|date_format:H:i',
                'PRESIDENTE' => 'required',
                'SECRETARIO' => 'required',
            ]);
            if($validator->fails()){
                $data = [
                    'message' => 'Error en la validación de los datos',
                    'errors' => $validator->errors(),
                    'status' => 400
                ];
                return response()->json($data,400);
            }
            $sesion = Sesion::create([
                'LUGAR' => $request ->LUGAR,
                'FECHA' => $request ->FECHA,
                'HORARIO_INICIO' => $request->HORARIO_INICIO,
                'HORARIO_FINAL' => $request ->HORARIO_FINAL,
                'PRESIDENTE' => $request-> PRESIDENTE,
                'SECRETARIO' => $request-> SECRETARIO
            ]);
            if(!$sesion){
                $data = [
                    'message' => 'Error al crear sesion',
                    'status' => 500
                ];
                return response()->json($data,500);
            }
            $data = [
                'sesion' => $sesion,
                'User' => Auth::user(),
                'status' => 201
            ];
            return response()->json($data,201);

        }catch (Exception | AuthorizationException $e){
            return response()->json(['error' => $e->getMessage()]);
        }


    }

    public function show($IDSESION){

        try{
            $this->authorize('view', Session::class);

            $sesion = Sesion::find($IDSESION);
            if(!$sesion){
                $data =[
                    'message' => 'Sesion no encontrada',
                    'status' => 404
                ];
                return response()->json($data,404);
            }
            $data = [
                'sesion' => $sesion,
                'status' => 200
            ];
            return response()->json($data,200);
        }catch (Exception | AuthorizationException $e){
            return response()->json(['error' => $e->getMessage()]);
        }

    }

    public function delete($IDSESION)
    {

        try {

            $this->authorize("delete", Session::class);

            $sesion = Sesion::find($IDSESION);

            if (!$sesion) {
                return response()->json([
                    'message' => 'Sesión no encontrada',
                    'status' => 404
                ], 404);
            }

            // Buscar y eliminar el acta asociada con la columna SESION_IDSESION
            $acta = Acta::where('SESION_IDSESION', $IDSESION)->first();
            if ($acta) {
                $acta->delete();
            }

            $sesion->delete();

            return response()->json([
                'message' => 'Sesión y acta eliminadas',
                'status' => 200
            ], 200);
        }catch (Exception | AuthorizationException $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }



    public function update(Request $request, $IDSESION){

        try {

            $this->authorize('update', Session::class);

            $sesion = sesion::find($IDSESION);
            if (!$sesion) {
                $data = [
                    'message' => 'Sesión no encontrada',
                    'status' => 404
                ];
                return response()->json($data, 404);
            }
            $validator = Validator::make($request->all(), [
                'LUGAR' => 'required',
                'FECHA' => 'required|date',
                'HORARIO_INICIO' => 'required|date_format:H:i',
                'HORARIO_FINAL' => 'required|date_format:H:i',
                'PRESIDENTE' => 'required',
                'SECRETARIO' => 'required',
            ]);
            if ($validator->fails()) {
                $data = [
                    'message' => 'Error en la validación de los datos',
                    'errors' => $validator->errors(),
                    'status' => 400
                ];
                return response()->json($data, 400);

            }
            $sesion->LUGAR = $request->LUGAR;
            $sesion->FECHA = $request->FECHA;
            $sesion->HORARIO_INICIO = $request->HORARIO_INICIO;
            $sesion->HORARIO_FINAL = $request->HORARIO_FINAL;
            $sesion->PRESIDENTE = $request->PRESIDENTE;
            $sesion->SECRETARIO = $request->SECRETARIO;

            $sesion->save();

            $data = [
                'message' => 'Sesion actualizada',
                'sesion' => $sesion,
                'status' => 200
            ];
            return response()->json($data, 200);

        }catch (Exception | AuthorizationException $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function update_patch(Request $request, $IDSESION){

        try {
            $this->authorize('update', Session::class);

            $sesion = Sesion::find($IDSESION);

            if (!$sesion) {
                $data = [
                    'message' => 'Sesion no encontrada',
                    'status' => 404
                ];
                return response()->json($data, 404);
            }

            $validator = Validator::make($request->all(), [
                'LUGAR' => 'max:255',
                'FECHA' => 'date',
                'HORARIO_INICIO' => 'date_format:H:i',
                'HORARIO_FINAL' => 'date_format:H:i',
                'PRESIDENTE' => 'max:255',
                'SECRETARIO' => 'max:255'
            ]);

            if ($validator->fails()) {
                $data = [
                    'message' => 'Error en la validación de los datos',
                    'errors' => $validator->errors(),
                    'status' => 400
                ];
                return response()->json($data, 400);

            }
            if ($request->has('LUGAR')) {
                $sesion->LUGAR = $request->LUGAR;
            }
            if ($request->has('FECHA')) {
                $sesion->FECHA = $request->FECHA;
            }
            if ($request->has('HORARIO_INICIO')) {
                $sesion->HORARIO_INICIO = $request->HORARIO_INICIO;
            }
            if ($request->has('HORARIO_FINAL')) {
                $sesion->HORARIO_FINAL = $request->HORARIO_FINAL;
            }
            if ($request->has('PRESIDENTE')) {
                $sesion->PRESIDENTE = $request->PRESIDENTE;
            }
            if ($request->has('SECRETARIO')) {
                $sesion->SECRETARIO = $request->SECRETARIO;
            }

            $sesion->save();

            $data = [
                'message' => 'Sesion actualizada',
                'sesion' => $sesion,
                'status' => 200
            ];
            return response()->json($data, 200);

        }catch (Exception | AuthorizationException $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
