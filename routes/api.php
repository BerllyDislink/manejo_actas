<?php

use App\Http\Controllers\sesion_controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//CRUD sesion
Route::get('/sesion',[sesion_controller::class, 'index']);

Route::get('/sesion/{IDSESION}',[sesion_controller::class, 'show']); //encontrar sesion por id

Route::post('/sesion',[sesion_controller::class, 'store']);

Route::delete('/sesion/{IDSESION}', [sesion_controller::class, 'delete']);

Route::put('/sesion/{IDSESION}', [sesion_controller::class, 'update']);


Route::patch('/sesion/{IDSESION}', [sesion_controller::class, 'update_patch']);

