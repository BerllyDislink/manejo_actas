<?php

use App\Http\Controllers\ActaController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\EncargadosTareaController;
use App\Http\Controllers\ParticipantesController;
use App\Http\Controllers\sesion_controller;
use App\Http\Controllers\orden_sesion_controller;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\proposicionesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



//CRUD Registro y login

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/profile', [AuthController::class, 'userProfile']);

    //CRUD sesion
    Route::post('/sesion/save',[sesion_controller::class, 'store']);
    Route::get('/sesion/all',[sesion_controller::class, 'index']);
    Route::get('/sesion/{id}',[sesion_controller::class, 'show']);
    Route::put('/sesion/update/{IDSESION}',[sesion_controller::class, 'update']);
    Route::patch('/sesion/update/{IDSESION}',[sesion_controller::class, 'update_patch']);
    Route::delete('/sesion/delete/{IDSESION}',[sesion_controller::class, 'delete']);
    //verificar quorum
    Route::get('/sesion/{IDSESION}/verificar-quorum', [ParticipantesController::class, 'verificarQuorum']);


    //CRUD Orden sesion
    Route::get('/orden_sesion/all',[orden_sesion_controller::class, 'index']);
    Route::get('/orden_sesion/{id}',[orden_sesion_controller::class, 'show']);
    Route::post('/orden_sesion/save',[orden_sesion_controller::class, 'store']);
    Route::put('/orden_sesion/update/{ID_ORDEN_SESION}',[orden_sesion_controller::class, 'update']);
    Route::patch('/orden_sesion/update/{ID_ORDEN_SESION}',[orden_sesion_controller::class, 'update_patch']);
    Route::delete('/orden_sesion/delete/{ID_ORDEN_SESION}',[orden_sesion_controller::class, 'delete']);

    //CRUD Acta
    Route::get('/acta/all',[ActaController::class, 'index']);
    Route::get('/acta/{id}',[ActaController::class, 'show']);
    Route::post('/acta/save', [ActaController::class, 'store']);
    Route::put('/acta/update/{id}',[ActaController::class, 'update']);
    Route::delete('acta/delete/{id}',[ActaController::class, 'destroy']);

    //CRUD Tareas
    Route::get('tarea/all', [TareaController::class, 'index']);
    Route::get('/tarea/{id}',[TareaController::class, 'show']);
    Route::post('/tarea/save', [TareaController::class, 'store']);
    Route::put('/tarea/update/{id}',[TareaController::class, 'update']);
    Route::delete('tarea/delete/{id}',[TareaController::class, 'destroy']);

    //CRUD Proposiciones
    Route::get('proposicion/all', [proposicionesController::class, 'index']);
    Route::get('/proposicion/{id}',[proposicionesController::class, 'show']);
    Route::post('/proposicion/save', [proposicionesController::class, 'store']);
    Route::put('/proposicion/update/{ID_PROPOSICIONES}',[proposicionesController::class, 'update']);
    Route::delete('proposicion/delete/{ID_PROPOSICIONES}',[proposicionesController::class, 'delete']);

    //CRUD invitados

});


//CRUD Encargado tarea

// Listar todos los encargados de tareas
Route::get('encargados_tarea/all', [EncargadosTareaController::class, 'index']);

// Mostrar un encargado de tarea por ID (usando los IDs de miembro y tarea)
Route::get('encargados_tarea/{miembroId}/{tareaId}', [EncargadosTareaController::class, 'show']);

// Guardar un nuevo encargado de tarea
Route::post('/encargados_tarea/save', [EncargadosTareaController::class, 'store']);

// Actualizar un encargado de tarea existente (usando los IDs de miembro y tarea)
Route::put('/encargados_tarea/update/{miembroId}/{tareaId}', [EncargadosTareaController::class, 'update']);

// Eliminar un encargado de tarea (usando los IDs de miembro y tarea)
Route::delete('encargados_tarea/delete/{miembroId}/{tareaId}', [EncargadosTareaController::class, 'destroy']);



//Agregar invitados
Route::post('/invitado', [ParticipantesController::class, 'agregarInvitado']);

//Obtener asistencia y crear estado de la asistencia de invitados
Route::get('/sesion/{IDSESION}/invitado/{IDINVITADOS}/asistencia', [ParticipantesController::class, 'obtenerAsistenciaInvitado']);
Route::post('/sesion/{IDSESION}/invitado/{IDINVITADOS}/asistencia', [ParticipantesController::class, 'registrarAsistencia']);


// Agregar miembro
Route::post('/miembro', [ParticipantesController::class, 'agregarMiembro']);

// Obtener asistencia de miembro y crear estado de la asistencia de miembros
Route::get('/sesion/{IDSESION}/miembro/{IDMIEMBRO}/asistencia', [ParticipantesController::class, 'obtenerAsistenciaMiembro']);
Route::post('/sesion/{IDSESION}/miembro/{IDMIEMBRO}/asistencia', [ParticipantesController::class, 'registrarAsistenciaMiembro']);



