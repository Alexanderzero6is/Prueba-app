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

        <form action="/api/login" method="POST">

            <label>
                Usuario:
                <input
                    type="text"
                    name="nombre_apellido"
                    placeholder="nombre_apellido"
                    class="border border-gray-300 rounded px-3"
                    required
                />
            </label><br><br>

            <label>
                Contraseña:
                <input
                    type="password"
                    name="contraseña"
                    placeholder="contraseña"
                    class="border border-gray-300 rounded px-3"
                    required
                />
            </label><br><br>

            <button type="submit" class="border rounded bg-blue-600 px-4 py-2 text-white">
                Login
            </button>

            <button type="submit" class="border rounded bg-blue-600 px-4 py-2 text-white">
                <a href="{{route('posts.create')}}">Create account</a>
            </button>
        </form>
    </div>
</x-app-layout>
