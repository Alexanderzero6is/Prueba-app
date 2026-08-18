<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiCrudController; // <-- 1. Importa tu controlador aquí

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// 2. Crea tu ruta POST aquí abajo
Route::post('/registro', [ApiCrudController::class, 'store']);