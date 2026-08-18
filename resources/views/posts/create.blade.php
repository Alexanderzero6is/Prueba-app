<x-app-layout>
    <h1 class="text-3xl font-bold">Registro de datos</h1>
    <form>
        <label>
            Usario:
            <input
                type="text"
                name="nombre_apellido"
                placeholder="nombre_apellido"
                class="border border-gray-300 rounded px-3"
            />
        </label><br><br>

        <label>
            Contraseña:
            <input
                type="text"
                name="contraseña"
                placeholder="contraseña"
                class="border border-gray-300 rounded px-3"
            />
        </label><br><br>

        <label>
            Repetir contraseña:
            <input
                type="text"
                name="contraseña"
                placeholder="contraseña"
                class="border border-gray-300 rounded px-3"
            />
        </label><br><br>

        <button type="submit" class="border rounded bg-blue-600 px-4 py-2 text-white">
            <a href="{{route('posts.show', ['post' => 1])}}">Registrarse</a>
        </button>
    </form>
</x-app-layout>
