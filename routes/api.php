<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiCrudController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Ruta de Post para registrar un usuario en la base de datos usando SQL puro
Route::post('/registro', [ApiCrudController::class, 'store']);

// Ruta de Post para iniciar sesión y generar un token de acceso usando SQL puro
Route::post('/login', [ApiCrudController::class, 'login']);

// Ruta de Post para cerrar sesión y eliminar el token de acceso
Route::post('/logout', [ApiCrudController::class, 'logout']);

// Ruta para editar los datos del usuario
Route::post('/actualizar', [ApiCrudController::class, 'update']);
