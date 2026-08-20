<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function create()
    {
        return view('posts.create');
    }

    public function edit()
    {
        return view('posts.edit');
    }

    public function show(Request $request)
    {
        $usuario = $request->attributes->get('usuario_intranet');

        return view('posts.show', [
            'usuario' => $usuario,
        ]);
    }
}
