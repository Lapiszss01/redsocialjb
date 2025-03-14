<x-app-layout meta-title="Usuarios" meta-description="Administracion de usuarios">
    <div class="container">
        <h1 class="text-2xl font-bold mb-4">Administración de Usuarios</h1>
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
            <tr class="bg-gray-200">
                <th class="py-2 px-4 border">ID</th>
                <th class="py-2 px-4 border">Nombre</th>
                <th class="py-2 px-4 border">Email</th>
                <th class="py-2 px-4 border">Rol</th>
                <th class="py-2 px-4 border">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr class="border">
                    <td class="py-2 px-4">{{ $user->id }}</td>
                    <td class="py-2 px-4">{{ $user->name }}</td>
                    <td class="py-2 px-4">{{ $user->email }}</td>
                    <td class="py-2 px-4">{{ $user->role_id == 1 ? 'Administrador' : 'Usuario' }}</td>
                    <td class="py-2 px-4">
                        <a href="#" class="text-blue-500">Editar</a> |
                        <form action="#" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
