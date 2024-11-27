<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use App\Models\OrdenSesion;
use App\Models\acta;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class orden_sesion_controller extends Controller
{
    // para obtener los datos de sesion
    public function index(){

        try {
            $this->authorize('viewAny', OrdenSesion::class);

            $ordensesion = OrdenSesion::all();
            $data = [
                'orden_sesion' => $ordensesion,
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
            $this->authorize('create', OrdenSesion::class);

            $validator = Validator::make($request->all(), [
                'TEMA' => 'required',
                'DESCRIPCION' => 'required',
                'SESION_IDSESION' => 'required',
                'orden' => 'required',
            ]);
            if ($validator->fails()) {
                $data = [
                    'message' => 'Error en la validación de los datos',
                    'errors' => $validator->errors(),
                    'status' => 400
                ];
                return response()->json($data, 400);
            }
            $ordensesion = OrdenSesion::create([
                'TEMA' => $request->TEMA,
                'DESCRIPCION' => $request->DESCRIPCION,
                'SESION_IDSESION' => $request->SESION_IDSESION,
                'orden' => $request->orden
            ]);
            if (!$ordensesion) {
                $data = [
                    'message' => 'Error al crear orden de la sesion',
                    'status' => 500
                ];
                return response()->json($data, 500);
            }
            $data = [
                'orden_sesion' => $ordensesion,
                'status' => 201
            ];
            return response()->json($data, 201);

        }catch (Exception | AuthenticationException $e){
            return response()->json(['message' => 'no se pudo guardar el orden de la sesion','description' => $e->getMessage()], 401);
        }
    }

    public function show($ID_ORDEN_SESION){

        try {
            $this->authorize('view', OrdenSesion::class);

            $ordensesion = OrdenSesion::find($ID_ORDEN_SESION);
            if (!$ordensesion) {
                $data = [
                    'message' => 'Sesion no encontrada',
                    'status' => 404
                ];
                return response()->json($data, 404);
            }
            $data = [
                'orden_sesion' => $ordensesion,
                'status' => 200
            ];
            return response()->json($data, 200);
        }catch (Exception | AuthenticationException $e){
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function delete($ID_ORDEN_SESION)
    {
        try {

            $this->authorize('delete', OrdenSesion::class);

            $ordensesion = OrdenSesion::find($ID_ORDEN_SESION);

            if (!$ordensesion) {
                return response()->json([
                    'message' => 'Sesión no encontrada',
                    'status' => 404
                ], 404);
            }

            // Buscar y eliminar el acta asociada con la columna SESION_IDSESION
            $acta = Acta::where('SESION_IDSESION', $ID_ORDEN_SESION)->first();
            if ($acta) {
                $acta->delete();
            }

            $ordensesion->delete();

            return response()->json([
                'message' => 'Orden de la sesión y acta eliminadas',
                'status' => 200
            ], 200);
        }catch (Exception | AuthenticationException $e){
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }



    public function update(Request $request, $ID_ORDEN_SESION){
        try {
            $this->authorize('update', OrdenSesion::class);
            $ordensesion = OrdenSesion::find($ID_ORDEN_SESION);
            if(!$ordensesion){
                $data = [
                    'message' => 'Sesión no encontrada',
                    'status' => 404
                ];
                return response()->json($data,404);
            }
            $validator = Validator::make($request->all(),[
                'TEMA' => 'required',
                'DESCRIPCION' => 'required',
                'SESION_IDSESION' => 'required',
                'orden' => 'required',
            ]);
            if($validator->fails()){
                $data = [
                    'message' => 'Error en la validación de los datos',
                    'errors' => $validator->errors(),
                    'status' => 400
                ];
                return response()->json($data,400);

            }
            $ordensesion->TEMA = $request ->TEMA;
            $ordensesion->DESCRIPCION = $request ->DESCRIPCION;
            $ordensesion->SESION_IDSESION = $request->SESION_IDSESION;
            $ordensesion->orden = $request->orden;

            $ordensesion->save();

            $data = [
                'message' => 'Sesion actualizada',
                'orden_sesion' => $ordensesion,
                'status' => 200
            ];
            return response()->json($data,200);
        }catch (Exception | AuthenticationException $e){
            return response()->json(['error' => $e->getMessage()], 401);
        }

    }

    public function update_patch(Request $request, $ID_ORDEN_SESION)
    {

        try {
            $this->authorize('update', OrdenSesion::class);

            $ordensesion = OrdenSesion::find($ID_ORDEN_SESION);

            if (!$ordensesion) {
                $data = [
                    'message' => 'Sesion no encontrada',
                    'status' => 404
                ];
                return response()->json($data, 404);
            }

            $validator = Validator::make($request->all(), [
                'TEMA' => 'max:255',
                'DESCRIPCION' => 'max:255',
                'SESION_ORDENSESION' => 'int',
                'orden' => 'required',
            ]);

            if ($validator->fails()) {
                $data = [
                    'message' => 'Error en la validación de los datos',
                    'errors' => $validator->errors(),
                    'status' => 400
                ];
                return response()->json($data, 400);

            }
            if ($request->has('TEMA')) {
                $ordensesion->TEMA = $request->TEMA;
            }
            if ($request->has('DESCRIPCION')) {
                $ordensesion->DESCRIPCION = $request->DESCRIPCION;
            }
            if ($request->has('SESION_IDSESION')) {
                $ordensesion->SESION_IDSESION = $request->SESION_IDSESION;
            }
            if($request->has('orden')){
                $ordensesion->orden = $request->orden;
            }

            $ordensesion->save();

            $data = [
                'message' => 'Sesion actualizada',
                'orden_sesion' => $ordensesion,
                'status' => 200
            ];
            return response()->json($data, 200);

        } catch (Exception|AuthenticationException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }


    public function getOrderSesionByIdSesion($IDSESION)
    {
        try{
            Gate::authorize('view', OrdenSesion::class);
            $orden = OrdenSesion::where('SESION_IDSESION', '=', $IDSESION)->orderBy('orden')->paginate(5);
            return response()->json($orden, 200);
        }catch (Exception $e){
            return response()->json(['message' => 'no se pudo obtener el orden de esta sesion','description' => $e->getMessage()], 401);
        }
    }

    public function getOrderSesionByIdSesionNotPaginated($IDSESION)
    {

            Gate::authorize('view', OrdenSesion::class);
            $orden = OrdenSesion::where('SESION_IDSESION', '=', $IDSESION)->get();
            return response()->json($orden, 200);
    }

    public function deleteByIdSesion($IDSESION)
    {
        try{
            Gate::authorize('delete', OrdenSesion::class);
            OrdenSesion::where('SESION_IDSESION', '=', $IDSESION)->delete();
            return response()->json(['message' => 'Item de orden se sesion eliminado correctamente'], 200);
        }catch (Exception $e){
            return response()->json(['message' => 'No se pudo eliminar el item del orden de sesion', 'description' => $e->getMessage()], 404);
        }
    }

}
