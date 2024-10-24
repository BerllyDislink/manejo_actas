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
        'IDSESION' => 'required',
        'LUGAR' => 'required',
        'FECHA' => 'required|date',
        'HORARIO_INICIO' => 'required|date_format:Y-m-d H:i:s',
        'HORARIO_FINAL' => 'required|date_format:Y-m-d H:i:s',
        'PRESIDENTE' => 'required',
        'SECRETARIO' => 'required' 
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
        'IDSESION' =>$request ->IDSESION,
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
}
