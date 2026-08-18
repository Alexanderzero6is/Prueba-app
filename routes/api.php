<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiCrudController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Ruta de Post para registrar un usuario en la base de datos usando SQL puro
Route::post('/registro', [ApiCrudController::class, 'store']);