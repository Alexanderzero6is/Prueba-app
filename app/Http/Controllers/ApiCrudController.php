<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiCrudController extends Controller
{
    public function store(Request $request)
    {
        // Se valida los datos que vienen del formulario
        $request->validate([
            'nombre_apellido' => 'required|string',
            'contraseña' => 'required|string'
        ]);

        try {
            // Consulta SQL pura inyectada
            // La tabla se llama 'usuarios' y tiene las columnas 'nombre' y 'password
            DB::insert('INSERT INTO usuarios (nombre, password) VALUES (?, ?)', [
                $request->nombre_apellido,
                Hash::make($request->contraseña) // Siempre hashear contraseñas
            ]);

            // Devolvemos una respuesta JSON de éxito
            return response()->json([
                'status' => true,
                'message' => 'Usuario registrado exitosamente en la base de datos.'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error al insertar en la base de datos: ' . $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        // Se validan los datos enviados
        $request->validate([
            'nombre_apellido' => 'required|string',
            'contraseña' => 'required|string'
        ]);

        try {
            // Se Busca al usuario usando SQL puro
            $usuarios = DB::select('SELECT * FROM usuarios WHERE nombre = ? LIMIT 1', [$request->nombre_apellido]);

            if (empty($usuarios)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            $usuario = $usuarios[0];

            // Verificación de la contraseña con el Hash
            if (!Hash::check($request->contraseña, $usuario->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Contraseña incorrecta'
                ], 401);
            }

            // Generación del Bearer Token manualmente (Sin Eloquent)
            $plainTextToken = bin2hex(random_bytes(40));
            $hashedToken = hash('sha256', $plainTextToken);

            // Se inserta el token en la tabla de Sanctum usando SQL puro
            DB::insert('INSERT INTO personal_access_tokens (tokenable_type, tokenable_id, name, token, abilities, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())', [
                'usuarios',
                $usuario->id,
                'API Token',
                $hashedToken,
                '["*"]'
            ]);

            // Se devuelve el token al usuario
            return response()->json([
                'status' => true,
                'message' => 'Login exitoso',
                'token' => $plainTextToken // Bearer Token que se usará en el CRUD
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error en el servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        // Se extrae el Bearer Token del header de la petición
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'status' => false,
                'message' => 'Token no proporcionado en la petición'
            ], 401);
        }

        // Se Hashea el token recibido (así es como lo guardamos en el login)
        $hashedToken = hash('sha256', $token);

        try {
            // Eliminamos el token de la base de datos con SQL puro
            $eliminado = DB::delete('DELETE FROM personal_access_tokens WHERE token = ?', [$hashedToken]);

            if ($eliminado) {
                return response()->json([
                    'status' => true,
                    'message' => 'Sesión cerrada correctamente. Token revocado.'
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'El token es inválido o la sesión ya estaba cerrada.'
                ], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error en el servidor: ' . $e->getMessage()
            ], 500);
        }
    }
}
