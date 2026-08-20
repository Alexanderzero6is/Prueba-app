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
            'contraseña' => 'required|string',
        ]);

        try {
            // Consulta SQL pura inyectada
            // La tabla se llama 'usuarios' y tiene las columnas 'nombre' y 'password'
            DB::insert('INSERT INTO usuarios (nombre, password) VALUES (?, ?)', [
                $request->nombre_apellido,
                Hash::make($request->contraseña), // Siempre hashear contraseñas
            ]);

            if ($request->expectsJson()) {
                // Devolvemos una respuesta JSON de éxito
                return response()->json([
                    'status' => true,
                    'message' => 'Usuario registrado exitosamente en la base de datos.'
                ], 201);
            }

            // Cuando cree la cuenta, que regrese a la ventana principal
            return redirect()
                ->route('posts.index')
                ->with('success', 'Cuenta creada correctamente.');

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error al insertar en la base de datos: '.$e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        // Se validan los datos enviados
        $request->validate([
            'nombre_apellido' => 'required|string',
            'contraseña' => 'required|string',
        ]);

        try {
            // Se Busca al usuario usando SQL puro
            $usuarios = DB::select('SELECT * FROM usuarios WHERE nombre = ? LIMIT 1', [$request->nombre_apellido]);

            if (empty($usuarios)) {
                // Si es Postman/Bruno
                if ($request->expectsJson()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Usuario no encontrado',
                    ], 404);
                }
                // Si es desde la web (Blade)
                return back()->withErrors(['nombre_apellido' => 'El usuario ingresado no existe.']);
            }

            $usuario = $usuarios[0];

            // Verificación de la contraseña con el Hash
            if (! Hash::check($request->contraseña, $usuario->password)) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Contraseña incorrecta',
                    ], 401);
                }
                return back()->withErrors(['contraseña' => 'La contraseña es incorrecta.']);
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
                '["*"]',
            ]);

            // Se devuelve el token al usuario y servira como postman
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login exitoso',
                    'token' => $plainTextToken, // Bearer Token que se usará en el CRUD
                ], 200);
            }

            // Si exista el usuario, entrará sin problemas a esta ruta
            return redirect()
                ->route('posts.show')
                ->withCookie(cookie(
                    'intranet_token',
                    $plainTextToken,
                    120,
                    '/',
                    null,
                    false,
                    true
                ));

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error en el servidor: '.$e->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        // Se extrae el Bearer Token del header de la petición
        $token = $request->bearerToken();

        // Si no viene como Bearer Token, se busca en la cookie de la intranet
        if (! $token) {
            $token = $request->cookie('intranet_token');
        }

        // Si no existe token ni en header ni en cookie
        if (! $token) {

            // Si es una petición API
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token no proporcionado en la petición',
                ], 401);
            }

            // Si viene desde Blade
            return redirect()->route('posts.index');
        }

        // Se Hashea el token recibido (así es como lo guardamos en el login)
        $hashedToken = hash('sha256', $token);

        try {
            // Eliminamos el token de la base de datos con SQL puro
            $eliminado = DB::delete('DELETE FROM personal_access_tokens WHERE token = ?', [$hashedToken]);

            if ($eliminado) {
                // Si se está utilizando como API
                if ($request->expectsJson()) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Sesión cerrada correctamente. Token revocado.',
                    ], 200);
                }

                // Si se está utilizando desde Blade
                return redirect()
                    ->route('posts.index')
                    ->withoutCookie('intranet_token');
            } else {
                if ($request->expectsJson()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'El token es inválido o la sesión ya estaba cerrada.',
                    ], 404);
                }

                return redirect()
                    ->route('posts.index')
                    ->withoutCookie('intranet_token');
            }

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Error en el servidor: '.$e->getMessage(),
                ], 500);
            }

            return redirect()->route('posts.index');
        }
    }

    public function update(Request $request)
    {
        // Validamos los datos enviados desde el formulario
        $request->validate([
            'nombre_apellido' => 'required|string',
            'contraseña' => 'nullable|string',
        ]);

        // Primero intentamos obtener el Bearer Token
        $token = $request->bearerToken();

        // Si viene desde Blade, usamos la cookie
        if (! $token) {
            $token = $request->cookie('intranet_token');
        }

        // Si no existe token, el usuario no está autenticado
        if (! $token) {
            return response()->json([
                'status' => false,
                'message' => 'Token no proporcionado.',
            ], 401);
        }

        // Hasheamos el token para compararlo con la BD
        $hashedToken = hash('sha256', $token);

        try {

            // Buscamos a qué usuario pertenece el token
            $registroToken = DB::selectOne(
                'SELECT tokenable_id
             FROM personal_access_tokens
             WHERE token = ?
             LIMIT 1',
                [$hashedToken]
            );

            if (! $registroToken) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token inválido.',
                ], 401);
            }

            // Obtenemos el ID del usuario autenticado
            $usuarioId = $registroToken->tokenable_id;

            // Si el usuario escribió una nueva contraseña
            if ($request->filled('contraseña')) {

                DB::update(
                    'UPDATE usuarios
                 SET nombre = ?, password = ?
                 WHERE id = ?',
                    [
                        $request->nombre_apellido,
                        Hash::make($request->contraseña),
                        $usuarioId,
                    ]
                );

            } else {

                // Si no escribió contraseña,
                // actualizamos solamente el nombre
                DB::update(
                    'UPDATE usuarios
                 SET nombre = ?
                 WHERE id = ?',
                    [
                        $request->nombre_apellido,
                        $usuarioId,
                    ]
                );
            }

            // Si se utiliza como API
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Usuario actualizado correctamente.',
                ], 200);
            }

            // Si viene desde Blade
            return redirect()
                ->route('posts.show')
                ->with('success', 'Datos actualizados correctamente.');

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Error al actualizar el usuario: '.$e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        // Primero intentamos obtener el Bearer Token
        $token = $request->bearerToken();

        // Si viene desde Blade, buscamos el token en la cookie
        if (! $token) {
            $token = $request->cookie('intranet_token');
        }

        // Si no existe token, no sabemos qué usuario eliminar
        if (! $token) {
            return response()->json([
                'status' => false,
                'message' => 'Token no proporcionado.',
            ], 401);
        }

        // Hasheamos el token para buscarlo en MySQL
        $hashedToken = hash('sha256', $token);

        try {

            // Buscamos a qué usuario pertenece el token
            $registroToken = DB::selectOne(
                'SELECT tokenable_id
             FROM personal_access_tokens
             WHERE token = ?
             LIMIT 1',
                [$hashedToken]
            );

            if (! $registroToken) {

                if ($request->expectsJson()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Token inválido.',
                    ], 401);
                }

                return redirect()->route('posts.index');
            }

            // Obtenemos el ID del usuario autenticado
            $usuarioId = $registroToken->tokenable_id;


            // Iniciamos una transacción
            DB::beginTransaction();

            // Primero eliminamos todos los tokens de ese usuario
            DB::delete(
                'DELETE FROM personal_access_tokens
             WHERE tokenable_id = ?',
                [$usuarioId]
            );

            // Después eliminamos al usuario
            $eliminado = DB::delete(
                'DELETE FROM usuarios
             WHERE id = ?',
                [$usuarioId]
            );

            DB::commit();


            if (! $eliminado) {

                if ($request->expectsJson()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Usuario no encontrado.',
                    ], 404);
                }

                return redirect()->route('posts.index');
            }


            // Si viene desde Postman / API
            if ($request->expectsJson()) {

                return response()->json([
                    'status' => true,
                    'message' => 'Cuenta eliminada correctamente.',
                ], 200);
            }


            // Si viene desde Blade
            return redirect()
                ->route('posts.index')
                ->withoutCookie('intranet_token');


        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Error al eliminar la cuenta: '.$e->getMessage(),
            ], 500);
        }
    }
}
