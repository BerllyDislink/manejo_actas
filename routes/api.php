<?php

use App\Http\Controllers\ActaController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\AsistenciaInvitadosController;
use App\Http\Controllers\AsistenciaMiembrosController;
use App\Http\Controllers\DescripcionController;
use App\Http\Controllers\EncargadosTareaController;
use App\Http\Controllers\EncargadosTareaMiembrosController;
use App\Http\Controllers\InvitadosController;
use App\Http\Controllers\MiembrosController;
use App\Http\Controllers\ParticipantesController;
use App\Http\Controllers\sesion_controller;
use App\Http\Controllers\orden_sesion_controller;
use App\Http\Controllers\SesionInvitadosController;
use App\Http\Controllers\SolicitanteController;
use App\Http\Controllers\SolicitudController;
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


    Route::get('/testAPI', [AuthController::class, function () {
        return response()->json("Hola mundo API ManejoActas");
    }]);

    Route::get('/profile', [AuthController::class, 'userProfile']);

    //CRUD sesion
    Route::post('/sesion/save',[sesion_controller::class, 'store']);
    Route::get('/sesion/all',[sesion_controller::class, 'index']);
    Route::get('/sesion/{id}',[sesion_controller::class, 'show']);
    Route::put('/sesion/update/{IDSESION}',[sesion_controller::class, 'update']);
    Route::patch('/sesion/update/{IDSESION}',[sesion_controller::class, 'update_patch']);
    Route::delete('/sesion/delete/{IDSESION}',[sesion_controller::class, 'delete']);

    //verificar quorum
    Route::get('/sesion/{IDSESION}/verificar-quorum', [sesion_controller::class, 'verificarQuorum']);


    //CRUD Orden sesion
    Route::get('/orden_sesion/all',[orden_sesion_controller::class, 'index']);
    Route::get('/orden_sesion/{id}',[orden_sesion_controller::class, 'show']);
    Route::get('/orden_sesionBySesion/{IDSESION}', [orden_sesion_controller::class, 'getOrderSesionByIdSesion']);
    Route::get('/orden_sesionBySesionNotPaginate/{IDSESION}', [orden_sesion_controller::class, 'getOrderSesionByIdSesionNotPaginated']);
    Route::post('/orden_sesion/save',[orden_sesion_controller::class, 'store']);
    Route::put('/orden_sesion/update/{ID_ORDEN_SESION}',[orden_sesion_controller::class, 'update']);
    Route::patch('/orden_sesion/update/{ID_ORDEN_SESION}',[orden_sesion_controller::class, 'update_patch']);
    Route::delete('/orden_sesion/delete/{ID_ORDEN_SESION}',[orden_sesion_controller::class, 'delete']);
    Route::delete('/orden_sesion/deleteBySesion/{IDSESION}',[orden_sesion_controller::class, 'deleteByIdSesion']);

    //CRUD Acta
    Route::get('/acta/all',[ActaController::class, 'index']);
    Route::get('/acta/{id}',[ActaController::class, 'show']);
    Route::post('/acta/save', [ActaController::class, 'store']);
    Route::put('/acta/update/{id}',[ActaController::class, 'update']);
    Route::delete('acta/delete/{id}',[ActaController::class, 'destroy']);
    Route::put('/acta/estado/{id}',[ActaController::class, 'aprobarActaAnterior']);
    Route::get('/actaOfSesion/{IDSESION}', [ActaController::class , 'getActaById']);
    Route::delete('acta/deleteBySesion/{IDSESION}', [ActaController::class , 'deleteByIdSesion']);

    //CRUD Tareas
    Route::get('tarea/all', [TareaController::class, 'index']);

    //otra vista
    Route::get('/tareas', [TareaController::class, 'getTareas']);
    Route::get('/tareas/sesion/{idSesion}', [TareaController::class, 'getTareasBySession']);


    Route::get('/tarea/{id}',[TareaController::class, 'show']);
    Route::post('/tarea/save', [TareaController::class, 'store']);
    Route::put('/tarea/update/{id}',[TareaController::class, 'update']);
    Route::delete('tarea/delete/{id}',[TareaController::class, 'destroy']);
    Route::delete('tarea/deleteBySesion/{IDSESION}',[TareaController::class, 'deleteByIdSesion']);

    //CRUD Proposiciones
    Route::get('proposicion/all', [proposicionesController::class, 'index']);
    Route::get('/proposicion/{id}',[proposicionesController::class, 'show']);
    Route::post('/proposicion/save', [proposicionesController::class, 'store']);
    Route::put('/proposicion/update/{ID_PROPOSICIONES}',[proposicionesController::class, 'update']);
    Route::put('/proposicion/decision/{ID_PROPOSICIONES}',[proposicionesController::class, 'actualizarDecision']);
    Route::delete('proposicion/delete/{ID_PROPOSICIONES}',[proposicionesController::class, 'delete']);
    Route::delete('proposicion/deleteBySesion/{IDSESION}',[proposicionesController::class, 'deleteByIdSesion']);
    Route::get('/proposicionOfSesion/{IDSESION}', [proposicionesController::class, 'getProposicionesBySesion']);
    Route::get('/proposicionOfSesionNotPaginate/{IDSESION}', [proposicionesController::class, 'getProposicionesBySesionNotPaginated']);


    //CRUD invitados

    //Rutas de Miembros
    Route::get('miembro/allInf', [MiembrosController::class, 'getMiembros']);

    //Rutas AsistenciaMiembros
    Route::get('/asistenciaMiembros/all', [AsistenciaMiembrosController::class, 'index']);
    Route::post('/asistenciaMiembros/save', [AsistenciaMiembrosController::class, 'store']);
    Route::put('/asistenciaMiembros/update/{idSesion}/{idMiembro}', [AsistenciaMiembrosController::class, 'update']);
    Route::delete('/asistenciaMiembros/delete/{idSesion}/{idMiembro}', [AsistenciaMiembrosController::class, 'destroy']);
    Route::delete('/asistenciaMiembros/deleteBySesion/{idSesion}', [AsistenciaMiembrosController::class, 'deleteByIdSesion']);

    //Rutas AsistenciaInvitados
    Route::post('/asistenciaInvitados/save', [AsistenciaInvitadosController::class, 'store']);
    Route::put('/asistenciaInvitados/update/{idSesion}/{idInvitado}', [AsistenciaInvitadosController::class, 'update']);
    Route::delete('/asistenciaInvitados/delete/{idSesion}/{idInvitado}', [AsistenciaInvitadosController::class, 'destroy']);
    Route::delete('/asistenciaInvitados/deleteBySesion/{idSesion}', [AsistenciaInvitadosController::class, 'deleteByIdSesion']);

    //Rutas de Invitados
    Route::get('/invitado/InvitadosWithOutStudents', [InvitadosController::class, 'getInvitadosWithOutStudentsRole']);

    //Solicitudes, solicitantes, descripcion
    Route::apiResource('solicitudes',   SolicitudController::class);
    Route::apiResource('solicitantes',  SolicitanteController::class);
    Route::apiResource('descripciones', DescripcionController::class);
    Route::get('solicitudes/All/{IDSESION}', [SolicitudController::class , 'indexNoPaginate']);


    //Asistencias a la reunion
    Route::get('/memberInvitedToSesion/{IDSESION}', [SesionInvitadosController::class, 'getMemberInvitedToSesion']);
    Route::get('/guestInvitedToSesion/{IDSESION}', [SesionInvitadosController::class, 'getGuestInvitedToSesion']);
    Route::get('/memberInvitedToSesionNoPaginate/{IDSESION}', [SesionInvitadosController::class, 'getMemberInvitedToSesionNoPaginate']);
    Route::get('/guestInvitedToSesionNoPaginate/{IDSESION}', [SesionInvitadosController::class, 'getGuestInvitedToSesionNoPaginate']);
    Route::get('/memberInvitedToSesionByStatus/{idSesion}/{estado}', [SesionInvitadosController::class, 'getAsistenciaMiembrosByIdSesionAndStatus']);

    Route::get('/sesion/MiembrosInvitados',[sesion_controller::class, 'showInviteToSesion']);
    Route::get('encargados_tarea/all', [EncargadosTareaController::class, 'index']);
    Route::get('encargados_tarea/{miembroId}/{tareaId}', [EncargadosTareaController::class, 'show']);
    Route::post('/encargados_tarea/save', [EncargadosTareaController::class, 'store']);
    Route::put('/encargados_tarea/update/{miembroId}/{tareaId}', [EncargadosTareaController::class, 'update']);
    Route::delete('encargados_tarea/delete/{miembroId}/{tareaId}', [EncargadosTareaController::class, 'destroy']);
    Route::delete('encargados_tarea/deleteByTarea/{tareaId}', [EncargadosTareaController::class, 'deleteByIdTarea']);

    //Encargados tarea lista
    Route::get('/EncargadoListaTarea/{IDSESION}',[EncargadosTareaMiembrosController::class, 'getMemberInvitedToSesion']);
    Route::get('/tareas/TareasNotPaginate/{IDSESION}', [TareaController::class, 'getTareasByIdSesionNotPaginated']);
    Route::get("/encargadoTareaByIdSesion/{IDSESION}", [EncargadosTareaController::class, 'getEncargadoTareaByIdSesionNotPaginated']);

    //actualzación estado encargados_tarea

    Route::put('/encargados_tarea/update/{idTarea}', [EncargadosTareaController::class, 'updateEstadoTarea']);


});




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



