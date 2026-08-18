<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        return view('index');
    }

    public function create(){
        return view('posts.create');
    }
    public function edit(){
        return view('posts.edit');
    }
    public function show(){
        return view('posts.show');
    }
}
