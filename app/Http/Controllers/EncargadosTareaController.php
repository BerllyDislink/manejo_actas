<?php

namespace App\Http\Controllers;

use App\Models\EncargadosTarea;
use Illuminate\Http\Request;

class EncargadosTareaController extends Controller
{
    // Listar todos los encargados de tareas
    public function index()
    {
        $encargados = EncargadosTarea::with(['miembro', 'tarea'])->get();
        return response()->json($encargados);
    }

    // Mostrar un encargado de tarea por ID
    public function show($miembroId, $tareaId)
    {
        $encargado = EncargadosTarea::where('MIEMBROS_IDMIEMBROS', $miembroId)
                                      ->where('TAREAS_IDTAREAS', $tareaId)
                                      ->with(['miembro', 'tarea'])
                                      ->first();
        if (!$encargado) {
            return response()->json(['message' => 'Encargado de tarea no encontrado'], 404);
        }
        return response()->json($encargado);
    }

    // Guardar un nuevo encargado de tarea
    public function store(Request $request)
    {
        $request->validate([
            'MIEMBROS_IDMIEMBROS' => 'required|exists:miembros,IDMIEMBRO',
            'TAREAS_IDTAREAS' => 'required|exists:tareas,IDTAREAS', // Cambiado a IDTAREAS
            'ESTADO' => 'required|in:sin comenzar,en curso,finalizado'
        ]);

        // Establecer 'sin comenzar' como valor por defecto si no se proporciona
        $estado = $request->input('ESTADO', 'sin comenzar');

        $encargado = EncargadosTarea::create([
            'MIEMBROS_IDMIEMBROS' => $request->MIEMBROS_IDMIEMBROS,
            'TAREAS_IDTAREAS' => $request->TAREAS_IDTAREAS,
            'ESTADO' => $estado,
        ]);
        return response()->json($encargado, 201);
    }

    // Actualizar un encargado de tarea existente
    public function update(Request $request, $miembroId, $tareaId)
    {
        // Busca el encargado de tarea usando ambos IDs como clave compuesta
        $encargado = EncargadosTarea::where('MIEMBROS_IDMIEMBROS', $miembroId)
                                      ->where('TAREAS_IDTAREAS', $tareaId)
                                      ->first();
    
        // Verifica si se encontró el registro
        if (!$encargado) {
            return response()->json(['message' => 'Encargado de tarea no encontrado'], 404);
        }
    
        // Valida el estado si se está enviando
        $request->validate([
            'ESTADO' => 'sometimes|required|in:sin comenzar,en curso,finalizado'
        ]);
    
        // Actualiza solo los campos que se envían
        $encargado->update($request->only(['ESTADO']));
    
        // Devuelve la respuesta con el encargado actualizado
        return response()->json($encargado);
    }
    
    
    
    

    // Eliminar un encargado de tarea
    public function destroy($miembroId, $tareaId)
    {
        $deleted = EncargadosTarea::where('MIEMBROS_IDMIEMBROS', $miembroId)
                                    ->where('TAREAS_IDTAREAS', $tareaId)
                                    ->delete();
    
        if ($deleted) {
            return response()->json(['message' => 'Encargado de tarea eliminado correctamente.']);
        } else {
            return response()->json(['message' => 'No se encontró el encargado de tarea.'], 404);
        }
    }
    
}

