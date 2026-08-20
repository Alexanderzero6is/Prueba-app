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
            margin-top: 0;
            color: #111827;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            box-sizing: border-box;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            outline: none;
            transition: all 0.3s ease-in-out;
        }

        input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
        }

        input::placeholder {
            color: #9ca3af;
            opacity: 0.7;
            font-weight: normal;
        }

        button {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background-color: #1d4ed8;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 6px;
            font-weight: 600;
        }

        button:hover {
            background-color: #1e40af;
        }
    </style>

    <div class="login-container">
        <h2 class="text-3xl font-bold" style="margin-bottom: 20px;">Editar datos</h2>

        <form action="/api/actualizar" method="POST">

            <label style="font-weight: 600; color: #374151; font-size: 14px; margin-bottom: 5px; display: block;">
                Nombre de Usuario:
                <input
                    type="text"
                    name="nombre_apellido"
                    placeholder="Ej: Juan_Perez"
                    required
                >
            </label>
            <br>

            <label style="font-weight: 600; color: #374151; font-size: 14px; margin-bottom: 5px; display: block;">
                Contraseña:
                <input
                    type="password"
                    name="contraseña"
                    placeholder="••••••••"
                    required
                >
            </label>


            <button type="submit" style="background-color: blue; margin-top: 10px;">
                Guardar cambios
            </button>

        </form>
    </div>

</x-app-layout>
