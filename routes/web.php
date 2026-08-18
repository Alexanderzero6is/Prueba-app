<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])
    ->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])
    ->name('posts.create');
Route::get('/posts/{post}', [PostController::class, 'show'])
    ->name('posts.show');
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])
    ->name('posts.edit');
