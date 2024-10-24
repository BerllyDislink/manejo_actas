<?php

use App\Http\Controllers\sesion_controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//CRUD sesion
Route::get('/sesion',[sesion_controller::class, 'index']);

Route::post('/sesion',[sesion_controller::class, 'store']);