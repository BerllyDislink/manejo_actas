<?php

use App\Http\Controllers\ActaController;
use App\Http\Controllers\ParticipantesController;
use App\Http\Controllers\sesion_controller;
use App\Http\Controllers\orden_sesion_controller;
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
});

//CRUD sesion
Route::get('/sesion/all',[sesion_controller::class, 'index']);

Route::get('/sesion/{id}',[sesion_controller::class, 'show']);

Route::post('/sesion/save',[sesion_controller::class, 'store']);

Route::put('/sesion/update/{IDSESION}',[sesion_controller::class, 'update']);

Route::patch('/sesion/update/{IDSESION}',[sesion_controller::class, 'update_patch']);

Route::delete('/sesion/delete/{IDSESION}',[sesion_controller::class, 'delete']);

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

Route::put('/acta/aprobar/{id}', [ActaController::class, 'aprobarActaAnterior']); 

//CRUD Tareas

Route::get('tarea/all', [TareaController::class, 'index']);

Route::get('/tarea/{id}',[TareaController::class, 'show']);

Route::post('/tarea/save', [TareaController::class, 'store']);

Route::put('/tarea/update/{id}',[TareaController::class, 'update']);

Route::delete('tarea/delete/{id}',[TareaController::class, 'destroy']);

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

//verificar quorum
Route::get('/sesion/{IDSESION}/verificar-quorum', [ParticipantesController::class, 'verificarQuorum']);


