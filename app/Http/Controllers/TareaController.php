<?php

namespace App\Http\Controllers;


use App\Http\Requests\CreateActaRequest;
use App\Http\Requests\CreateTareaRequest;
use App\Http\Requests\UpdateTareaRequest;
use App\Http\Resources\TareaResource;
use App\Models\EncargadosTarea;
use App\Models\Tarea;
use Spatie\QueryBuilder\QueryBuilder;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Tarea::all();
        return response()->json(TareaResource::collection($tasks), 200);
    }

    public function getTareas()
{
    try {
        // Verificar permisos de acceso
        Gate::authorize('viewAny', Tarea::class);

        // Consulta para obtener todas las tareas con sus relaciones
        $tareas = QueryBuilder::for(Tarea::class)
            ->select(
                'tareas.IDTAREAS as tarea_id',
                'tareas.DESCRIPCION as descripcion',
                'tareas.FECHA_ENTREGA as fecha_entrega',
                'sesion.IDSESION as sesion_id',

                'encargados_tareas.ESTADO as estado_encargado',
                'miembros.IDMIEMBRO as miembro_id',
                'users.email as email_miembro',
                'miembros.NOMBRE as nombre'
            )
            ->join('sesion', 'sesion.IDSESION', '=', 'tareas.SESION_IDSESION') // Relación tarea -> sesión
            ->join('encargados_tareas', 'encargados_tareas.TAREAS_IDTAREAS', '=', 'tareas.IDTAREAS') // Relación tarea -> encargados
            ->join('miembros', 'miembros.IDMIEMBRO', '=', 'encargados_tareas.MIEMBROS_IDMIEMBROS') // Relación encargados -> miembros
            ->join('users', 'users.id', '=', 'miembros.user_id') // Relación miembros -> usuarios
            ->get();

        // Retornar datos en JSON
        return response()->json($tareas);
    } catch (Exception $e) {
        // Manejo de errores
        return response()->json(['message' => 'No se logró obtener las tareas', 'description' => $e->getMessage()], 404);
    }
}

//por sesion obtener las tareas
public function getTareasBySession($idSesion)
{
    try {
        // Verificar permisos de acceso
        Gate::authorize('viewAny', Tarea::class);

        // Filtrar tareas por la sesión especificada y obtener todos los resultados
        $tareas = QueryBuilder::for(Tarea::class)
            ->select(
                'tareas.IDTAREAS as tarea_id',
                'tareas.DESCRIPCION as descripcion',
                'tareas.FECHA_ENTREGA as fecha_entrega',
                'sesion.IDSESION as sesion_id',
                'encargados_tareas.ESTADO as estado_encargado',
                'miembros.IDMIEMBRO as miembro_id',
                'users.email as email_miembro',
                'miembros.NOMBRE as nombre'
            )
            ->join('sesion', 'sesion.IDSESION', '=', 'tareas.SESION_IDSESION') // Relación tarea -> sesión
            ->join('encargados_tareas', 'encargados_tareas.TAREAS_IDTAREAS', '=', 'tareas.IDTAREAS') // Relación tarea -> encargados
            ->join('miembros', 'miembros.IDMIEMBRO', '=', 'encargados_tareas.MIEMBROS_IDMIEMBROS') // Relación encargados -> miembros
            ->join('users', 'users.id', '=', 'miembros.user_id') // Relación miembros -> usuarios
            ->where('sesion.IDSESION', $idSesion) // Filtro por IDSESION
            ->orderByDesc('tareas.IDTAREAS')
            ->paginate(5); // Obtener todos los resultados sin paginación

        return response()->json($tareas);
    } catch (Exception $e) {
        return response()->json(['message' => 'No se logró obtener las tareas', 'description' => $e->getMessage()], 404);
    }
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
    public function store(CreateTareaRequest $request)
    {
        try{
            $TaskCreate = Tarea::create($request->validated());
            return response()->json(new TareaResource($TaskCreate), 201);
        }catch (Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if($id < 0){
            return response()->json(['error' => 'el id debe ser mayor que 0'], 400);
        }

        try{
            $task = Tarea::with('sesion')->findOrFail($id);
            return response()->json(new TareaResource($task), 200);
        }catch (Exception $e){
            return response()->json(['message' => 'No se encontro la tarea','error' => $e->getMessage()], 400);
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
    public function update(UpdateTareaRequest $request, string $id)
    {
        if($id <= 0){
            return response()->json(['error' => 'id del acta a actualizar debe ser mayor que 0'], 400);
        }

        try{
            $task = Tarea::findOrFail($id);
            $task->Update($request->validated());
            return response()->json(new TareaResource($task), 201);
        }catch (Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($id <= 0){
            return response()->json(['error' => 'id del acta a actualizar debe ser mayor que 0'], 400);
        }

        try {
            $task = Tarea::findOrFail($id);
            $task->delete();
            return response()->json("La tarea con el id: ".$id." fue eliminada", 204);
        }catch (Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function deleteByIdSesion($IDSESION)
    {
        try{
            Gate::authorize('delete', Tarea::class);
            Tarea::where('SESION_IDSESION', '=', $IDSESION)->delete();
            return response()->json(['message' => "La tarea se ha eliminado"], 200);
        }catch (Exception $e){
            return response()->json(['message' => 'Error al eliminar la tarea','description' => $e->getMessage()], 404);
        }
    }

    public function getTareasByIdSesionNotPaginated($IDSESION)
    {
        try{
            $tareas = Tarea::with('sesion', 'encargados_tareas', 'encargados_tareas.miembro')
                ->where('SESION_IDSESION', '=', $IDSESION)
                ->get();
            return response()->json(['data' => TareaResource::collection($tareas)], 200);
        }catch (Exception $e){
            return response()->json(['message' => 'Solicitudes no encontradas.'], 400);
        }
    }
}
