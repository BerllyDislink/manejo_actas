<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdenSesion;
use App\Models\acta;
use Illuminate\Support\Facades\Validator;

class orden_sesion_controller extends Controller
{
    // para obtener los datos de sesion
    public function index(){

        $ordensesion = OrdenSesion::all();
        $data = [
            'orden_sesion' => $ordensesion,
            'status' => 200
        ];
        return response()->json($data,200);
    }
   
    //para almancear las sesiones

    public function store(Request $request){
     $validator = Validator::make($request->all(),[
        'TEMA' => 'required',
        'DESCRIPCION' => 'required',
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
     $ordensesion = OrdenSesion::create([
        'TEMA' => $request ->TEMA,
        'DESCRIPCION' => $request ->DESCRIPCION,
        'SESION_IDSESION' => $request->SESION_IDSESION
     ]);
     if(!$ordensesion){
        $data = [
            'message' => 'Error al crear sesion',
            'status' => 500
        ];
        return response()->json($data,500);
     }
     $data = [
        'orden_sesion' => $ordensesion,
        'status' => 201
     ];
     return response()->json($data,201);
    }

    public function show($ID_ORDEN_SESION){
        $ordensesion = OrdenSesion::find($ID_ORDEN_SESION);
        if(!$ordensesion){
            $data =[
                'message' => 'Sesion no encontrada',
                'status' => 404
            ];
            return response()->json($data,404);
        }
        $data = [
            'orden_sesion' => $ordensesion,
            'status' => 200
        ];
        return response()->json($data,200);
    }

    public function delete($ID_ORDEN_SESION)
    {
        $ordensesion = OrdenSesion ::find($ID_ORDEN_SESION);
    
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
    }
    
    

    public function update(Request $request, $ID_ORDEN_SESION){
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
            $ordensesion->TEMA = $request ->TEMA;
            $ordensesion->DESCRIPCION = $request ->DESCRIPCION;
            $ordensesion->SESION_IDSESION = $request->SESION_IDSESION;

                $ordensesion->save();

                $data = [
                    'message' => 'Sesion actualizada',
                    'orden_sesion' => $ordensesion,
                    'status' => 200
                ];
                return response()->json($data,200);
    }

    public function update_patch(Request $request, $ID_ORDEN_SESION){
        $ordensesion = OrdenSesion::find($ID_ORDEN_SESION);

        if(!$ordensesion){
            $data = [
                'message'=> 'Sesion no encontrada',
                'status' => 404
            ];
            return response()->json($data,404);
        }
        
        $validator = Validator::make($request->all(),[
            'TEMA' => 'max:255',
            'DESCRIPCION' => 'max:255',
            'SESION_ORDENSESION' => 'int',
        ]);

        if($validator->fails()){
            $data = [
              'message' => 'Error en la validación de los datos',
              'errors' => $validator->errors(),
              'status' => 400
            ];
            return response()->json($data,400);

            }
            if($request->has('TEMA')){
                $ordensesion->TEMA = $request->TEMA;
            }
            if($request->has('DESCRIPCION')){
                $ordensesion->DESCRIPCION = $request->DESCRIPCION;
            }
            if($request->has('SESION_IDSESION')){
                $ordensesion->SESION_IDSESION = $request->SESION_IDSESION;
            }

            $ordensesion->save();

            $data = [
                'message'=> 'Sesion actualizada',
                'orden_sesion' => $ordensesion,
                'status' =>200
            ];
            return response()->json($data,200);
    }
}
