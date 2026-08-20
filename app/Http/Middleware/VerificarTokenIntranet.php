<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class VerificarTokenIntranet
{
    public function handle(Request $request, Closure $next): Response
    {
        // Obtenemos el token guardado en la cookie
        $token = $request->cookie('intranet_token');

        // Si no existe token, no ha iniciado sesión
        if (! $token) {
            return redirect('/');
        }

        // Hasheamos el token igual que hicimos durante el login
        $hashedToken = hash('sha256', $token);

        // Buscamos el token en la base de datos
        $registroToken = DB::selectOne(
            'SELECT * FROM personal_access_tokens WHERE token = ? LIMIT 1',
            [$hashedToken]
        );

        // Si no existe, el token no es válido
        if (! $registroToken) {
            return redirect('/');
        }

        $usuario = DB::selectOne(
            'SELECT * FROM usuarios WHERE id = ? LIMIT 1',
            [$registroToken->tokenable_id]
        );

        if (! $usuario) {
            return redirect('/');
        }

        // Guardamos temporalmente el usuario dentro del Request
        $request->attributes->set(
            'usuario_intranet',
            $usuario
        );

        // Si existe, permitimos continuar
        return $next($request);
    }
}
