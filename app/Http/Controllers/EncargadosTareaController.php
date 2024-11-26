<?php

namespace App\Http\Controllers;

use App\Models\EncargadosTarea;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Miembro;


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
    // Buscar si el encargado actual existe en la tabla EncargadosTarea
    $encargado = EncargadosTarea::where('MIEMBROS_IDMIEMBROS', $miembroId)
                                 ->where('TAREAS_IDTAREAS', $tareaId)
                                 ->first();

    // Verificar si el miembro enviado en la solicitud es diferente al miembro actual
    $nuevoMiembroId = $request->input('MIEMBROS_IDMIEMBROS');

    // Si el encargado ya existe y el miembro no cambia, solo actualizamos el estado
    if ($encargado) {
        // Si el miembro no ha cambiado, solo actualizamos el estado
        if ($miembroId == $nuevoMiembroId) {
            if ($request->has('ESTADO')) {
                // Solo actualizamos el estado
                $encargado->ESTADO = $request->input('ESTADO');
                $encargado->save();
                return response()->json($encargado);
            }
            return response()->json($encargado);
        } else {
            // Si el miembro cambia, eliminamos al encargado anterior
            $encargado->delete();

            // Si la tarea tiene un encargado anterior y la tarea debe ser eliminada
            // Verifica si la tarea debe ser eliminada, por ejemplo, si ya no tiene encargados
            $tarea = Tarea::find($tareaId);
            if ($tarea) {
                // Eliminar tarea si ya no tiene encargados
                if ($tarea->encargadosTarea->isEmpty()) {
                    $tarea->delete();
                }
            }
        }
    }

    // Si el miembro está siendo cambiado, verificamos si el nuevo miembro existe
    if ($nuevoMiembroId) {
        $miembro = Miembro::find($nuevoMiembroId);

        // Si el nuevo miembro no existe, lanzamos un error
        if (!$miembro) {
            return response()->json(['message' => 'Miembro no encontrado'], 404);
        }

        // Crear un nuevo encargado de tarea con el nuevo miembro
        $nuevoEncargado = EncargadosTarea::create([
            'MIEMBROS_IDMIEMBROS' => $miembro->IDMIEMBRO,
            'TAREAS_IDTAREAS' => $tareaId, // Mantener el ID de la tarea
            'ESTADO' => $request->input('ESTADO', 'sin comenzar'),
        ]);

        return response()->json($nuevoEncargado, 201);
    }

    // Si no se enviaron datos válidos para actualizar
    return response()->json(['message' => 'No se enviaron datos válidos para actualizar'], 400);
}

public function updateEstadoTarea($idTarea, Request $request)
{
    $estado = $request->input('estado');

    // Buscar el encargado de la tarea solo por el TAREAS_IDTAREAS
    $encargadoTarea = EncargadosTarea::where('TAREAS_IDTAREAS', $idTarea)->first();

    if ($encargadoTarea) {
        $encargadoTarea->ESTADO = $estado;
        $encargadoTarea->save();

        return response()->json([
            'message' => 'Estado actualizado con éxito',
            'data' => $encargadoTarea,
        ], 200);
    }

    return response()->json(['error' => 'Encargado de tarea no encontrado'], 404);
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


    public function deleteByIdTarea($tareaId)
    {
        try{
            Gate::authorize('delete', EncargadosTarea::class);
            $deleted = EncargadosTarea::where('TAREAS_IDTAREAS', $tareaId)->delete();

            if ($deleted) {
                return response()->json(['message' => 'Encargado de tarea eliminado correctamente.']);
            } else {
                return response()->json(['message' => 'No se encontró el encargado de tarea.'], 404);
            }
        }catch (Exception $e){
            response()->json(['message' => 'No se pudo eliminar el encargado de la tarea', 'description' => $e->getMessage()], 404);
        }

    }

}

