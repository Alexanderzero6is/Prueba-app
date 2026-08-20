<x-app-layout>
    <h1> Bienvenido, {{ $usuario->nombre }}</h1>
    <form action="/api/logout" method="POST">
        <button type="submit" class="border rounded bg-blue-600 px-4 py-2 text-white">
            Cerrar sesión
        </button>
    </form>

    <a href="{{ route('posts.edit') }}"
       class="border rounded bg-blue-600 px-4 py-2 text-white">
        Editar cuenta
    </a>

    <form action="/api/delete-account" method="POST">
        @method('DELETE')

        <button type="submit" style="background-color: red; color: white;">
            Eliminar cuenta
        </button>

    </form>
</x-app-layout>

