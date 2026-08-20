<x-app-layout>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
        }

        .navbar {
            background-color: #1e40af;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .navbar h1 {
            margin: 0;
            font-size: 22px;
            font-weight: bold;
        }

        .btn-logout {
            background-color: #ef4444;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .btn-logout:hover {
            background-color: #dc2626;
        }

        .dashboard-container {
            padding: 40px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .card {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
    </style>

    <!-- Barra de Navegación -->
    <nav class="navbar">
        <h1>Intranet Corporativa</h1>
        <div style="display: flex; align-items: center; gap: 20px;">
            <span style="font-size: 16px;">Bienvenido, <strong>{{ $usuario->nombre }}</strong></span>
            
            <form action="/logout" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">Cerrar sesión</button>
            </form>
        </div>
    </nav>

    <!-- Contenedor Principal -->
    <div class="dashboard-container">
        <div class="card">
            <h2 style="margin-top: 0; color: #111827; font-size: 24px; margin-bottom: 10px;">Panel de Gestión</h2>
            <p style="color: #4b5563; margin-bottom: 30px;">
                Desde este panel podrás administrar tu cuenta y visualizar los registros del sistema.
            </p>

            <!-- Separador visual y Botones de Alexander -->
            <div style="border-top: 1px solid #e5e7eb; padding-top: 20px; display: flex; gap: 15px; justify-content: center;">
                
                <a href="{{ route('posts.edit') }}" style="background-color: #2563eb; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: bold;">
                    Editar cuenta
                </a>

                <form action="delete-account" method="POST" style="margin: 0;">
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Estás seguro de eliminar tu cuenta? Esta acción no se puede deshacer.')" style="background-color: #dc2626; color: white; padding: 10px 20px; border-radius: 6px; border: none; cursor: pointer; font-weight: bold;">
                        Eliminar cuenta
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>