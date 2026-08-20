<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Página inicial - login
Route::get('/', [PostController::class, 'index'])
    ->name('posts.index');

// Página para crear cuenta
Route::get('/registro', [PostController::class, 'create'])
    ->name('posts.create');

// Página de la intranet
Route::get('/intranet', [PostController::class, 'show'])
    ->name('posts.show')
    ->middleware('intranet.auth');

// Página de usuarios
Route::get('/usuarios', [PostController::class, 'usuarios'])
    ->name('posts.usuarios')
    ->middleware('intranet.auth');

// Página para editar tu cuenta
Route::get('/editar', [PostController::class, 'edit'])
    ->name('posts.edit');
