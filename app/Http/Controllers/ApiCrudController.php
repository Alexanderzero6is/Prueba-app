<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiCrudController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validamos los datos que vienen del formulario de Alexander
        $request->validate([
            'nombre_apellido' => 'required|string',
            'contraseña' => 'required|string'
        ]);

        try {
            // 2. Consulta SQL pura inyectada (Sin Eloquent)
            // Asumiendo que tu tabla se llama 'usuarios'
            DB::insert('INSERT INTO usuarios (nombre, password) VALUES (?, ?)', [
                $request->nombre_apellido,
                Hash::make($request->contraseña) // Siempre hashear contraseñas
            ]);

            // 3. Devolvemos una respuesta JSON de éxito
            return response()->json([
                'status' => true,
                'message' => 'Usuario registrado exitosamente en la base de datos con SQL puro.'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error al insertar en la base de datos: ' . $e->getMessage()
            ], 500);
        }
    }
}
