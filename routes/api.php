<?php

use App\Http\Controllers\ActaController;
use App\Http\Controllers\sesion_controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//CRUD sesion
Route::get('/sesion/all',[sesion_controller::class, 'index']);

Route::get('/sesion/{id}',[sesion_controller::class, 'show']);

Route::post('/sesion/save',[sesion_controller::class, 'store']);

Route::put('/sesion/update/{IDSESION}',[sesion_controller::class, 'update']);

Route::patch('/sesion/update/{IDSESION}',[sesion_controller::class, 'update_patch']);

Route::delete('/sesion/delete/{IDSESION}',[sesion_controller::class, 'delete']);

//CRUD Orden sesion
Route::get('/orden_sesion/all',[sesion_controller::class, 'index']);

Route::get('/orden_sesion/{id}',[sesion_controller::class, 'show']);

Route::post('/orden_sesion/save',[sesion_controller::class, 'store']);

Route::put('/orden_sesion/update/{IDSESION}',[sesion_controller::class, 'update']);

Route::patch('/orden_sesion/update/{IDSESION}',[sesion_controller::class, 'update_patch']);

Route::delete('/orden_sesion/delete/{IDSESION}',[sesion_controller::class, 'delete']);


//CRUD Acta

Route::get('/acta/all',[ActaController::class, 'index']);

Route::get('/acta/{id}',[ActaController::class, 'show']);

Route::post('/acta/save', [ActaController::class, 'store']);

Route::put('/acta/update/{id}',[ActaController::class, 'update']);

Route::delete('acta/delete/{id}',[ActaController::class, 'destroy']);


