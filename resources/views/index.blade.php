<x-app-layout>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;

            display: flex;
            justify-content: center;
            align-items: center;

            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: white;
            padding: 30px;
            width: 350px;

            border-radius: 10px;

            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-top: 15px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;

            box-sizing: border-box;
        }

<<<<<<< HEAD
        input::placeholder {
            color: #9ca3af;
            opacity: 0.7;
            font-weight: normal;
        }

=======
>>>>>>> 598c370a72a3d6df6dfbd3b05eddaee346e65979
        button {
            width: 100%;
            padding: 10px;

            margin-top: 20px;

            background-color: #1d4ed8;
            color: white;

            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #1e40af;
        }

        .error {
            color: red;
            margin-top: 10px;
            text-align: center;
        }
    </style>

    <div class="login-container">
        <h2 class="text-3xl font-bold">Intranet - Login</h2>

        <form action="/login" method="POST">
            @csrf

            <label>
                Usuario:
                <input
                    type="text"
                    name="nombre_apellido"
                    placeholder="Ej: Juan Perez"
                    required
                />
                @error('nombre_apellido')
                    <div class="error">{{ $message }}</div>
                @enderror
            </label><br>

            <label>
                Contraseña:
                <input
                    type="password"
                    name="contraseña"
                    placeholder="••••••••"
                    required
                />
                @error('contraseña')
                    <div class="error">{{ $message }}</div>
                @enderror
            </label><br>

            <button type="submit" class="border rounded bg-blue-600 px-4 py-2 text-white">
                Login
            </button>

            <div style="text-align: center; margin-top: 15px;">
                <a href="{{ route('posts.create') }}" style="color: #2563eb; text-decoration: underline;">
                    ¿No tienes cuenta? Regístrate aquí
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
