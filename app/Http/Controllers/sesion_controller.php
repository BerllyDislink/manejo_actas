<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sesion;
use Illuminate\Support\Facades\Validator;

class sesion_controller extends Controller
{
    // para obtener los datos de sesion
    public function index(){

        $sesion = Sesion::all();
        $data = [
            'sesion' => $sesion,
            'status' => 200
        ];
        return response()->json($data,200);
    }
   
    //para almancear las sesiones

    public function store(Request $request){
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
        'status' => 201
     ];
     return response()->json($data,201);
    }

    public function show($IDSESION){
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
    }

    public function delete($IDSESION){
        $sesion = Sesion::find($IDSESION);
        if(!$sesion){
            $data = [
                'message' => 'Sesion no encontrada',
                'status' => 404
            ];
            return response()->json($data,404);
        }
        $sesion->delete();
        $data = [
            'message' => 'Sesión eliminada',
            'status' => 200
        ];
        return response()->json($data,200);
    }

    public function update(Request $request, $IDSESION){
        $sesion = sesion::find($IDSESION);
        if(!$sesion){
            $data = [
                'message' => 'Sesión no encontrada',
                'status' => 404
            ];
            return response()->json($data,404);
        }
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
            $sesion->LUGAR = $request ->LUGAR;
            $sesion->FECHA = $request ->FECHA;
            $sesion->HORARIO_INICIO = $request->HORARIO_INICIO;
            $sesion->HORARIO_FINAL = $request ->HORARIO_FINAL;
            $sesion->PRESIDENTE = $request-> PRESIDENTE;
            $sesion->SECRETARIO = $request-> SECRETARIO;
            
                $sesion->save();

                $data = [
                    'message' => 'Sesion actualizada',
                    'sesion' => $sesion,
                    'status' => 200
                ];
                return response()->json($data,200);
    }

    public function update_patch(Request $request, $IDSESION){
        $sesion = Sesion::find($IDSESION);

        if(!$sesion){
            $data = [
                'message'=> 'Sesion no encontrada',
                'status' => 404
            ];
            return response()->json($data,404);
        }
        
        $validator = Validator::make($request->all(),[
            'LUGAR' => 'max:255',
            'FECHA' => 'date',
            'HORARIO_INICIO' => 'date_format:H:i',
            'HORARIO_FINAL' => 'date_format:H:i',
            'PRESIDENTE' => 'max:255',
            'SECRETARIO' => 'max:255'
        ]);

        if($validator->fails()){
            $data = [
              'message' => 'Error en la validación de los datos',
              'errors' => $validator->errors(),
              'status' => 400
            ];
            return response()->json($data,400);

            }
            if($request->has('LUGAR')){
                $sesion->LUGAR = $request->LUGAR;
            }
            if($request->has('FECHA')){
                $sesion->FECHA = $request->FECHA;
            }
            if($request->has('HORARIO_INICIO')){
                $sesion->HORARIO_INICIO = $request->HORARIO_INICIO;
            }
            if($request->has('HORARIO_FINAL')){
                $sesion->HORARIO_FINAL = $request->HORARIO_FINAL;
            }
            if($request->has('PRESIDENTE')){
                $sesion->PRESIDENTE = $request->PRESIDENTE;
            }
            if($request->has('SECRETARIO')){
                $sesion->SECRETARIO = $request->SECRETARIO;
            }

            $sesion->save();

            $data = [
                'message'=> 'Sesion actualizada',
                'sesion' => $sesion,
                'status' =>200
            ];
            return response()->json($data,200);
    }
}
