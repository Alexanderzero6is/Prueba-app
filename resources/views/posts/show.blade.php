<x-app-layout>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6; /* Fondo gris claro */
            margin: 0;
        }

        /* Estilos de la barra superior */
        .navbar {
            background-color: #1e40af; /* Azul corporativo */
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
            background-color: #ef4444; /* Rojo para destacar el cierre de sesión */
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

        /* Estilos del área de trabajo */
        .dashboard-container {
            padding: 40px;
            max-width: 1000px;
            margin: 0 auto; /* Centrado */
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
            
            <form action="/api/logout" method="POST" style="margin: 0;">
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

            <!-- Separador visual -->
            <div style="border-top: 1px solid #e5e7eb; padding-top: 20px; text-align: center;">
                <p style="color: #9ca3af; font-size: 14px; font-style: italic;">
                    [ Aquí se insertarán los botones y el formulario para Actualizar y Eliminar la cuenta ]
                </p>
            </div>
        </div>
    </div>
</x-app-layout>