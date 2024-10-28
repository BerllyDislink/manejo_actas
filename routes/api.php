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

Route::post('/sesion/save',[sesion_controller::class, 'store']);



//CRUD Acta

Route::get('/acta/all',[ActaController::class, 'index']);

Route::get('/acta/{id}',[ActaController::class, 'show']);

Route::post('/acta/save', [ActaController::class, 'store']);

Route::put('/acta/update/{id}',[ActaController::class, 'update']);

Route::delete('acta/delete/{id}',[ActaController::class, 'destroy']);


