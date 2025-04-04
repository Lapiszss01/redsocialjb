<div>

    <div class="my-2 py-2">
        <button wire:click="deleteInactiveUsers" class="btn btn-danger bg-red-500 text-white px-2 py-1 rounded">Eliminar usuarios inactivos</button>

        <button wire:click="deleteInactivePosts" class="btn btn-danger bg-red-500 text-white px-2 py-1 rounded">Eliminar posts inactivos</button>

        @if($message)
            <p style="color: green;">{{ $message }}</p>
        @endif
    </div>

    <table class="min-w-full bg-white border border-gray-300">
        <thead>
        <tr class="bg-gray-200">
            <th class="py-2 px-4 border">Nombre</th>
            <th class="py-2 px-4 border">Email</th>
            <th class="py-2 px-4 border">Rol</th>
            <th class="py-2 px-4 border">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr class="border">
                <td class="py-2 px-4">{{ $user->name }}</td>
                <td class="py-2 px-4">{{ $user->email }}</td>
                <td class="py-2 px-4">
                    <livewire:components.selectcomponent :userId="$user->id" :roleId="$user->role_id" :key="$user->id" />
                </td>
                <td class="py-2 px-4">
                    <button wire:click="editUser({{ $user->id }})" class="bg-blue-500 text-white px-2 py-1 rounded">Editar</button>
                    <button wire:click="confirmDelete({{ $user->id }})" class="bg-red-500 text-white px-2 py-1 rounded">Eliminar</button>
                </td>
            </tr>
        @endforeach
        <tr class="border">
            <td class="py-2 px-4">
                <button wire:click="openUserCreating()" class="bg-blue-500 text-white px-2 py-1 rounded">Crear usuario</button>
            </td>
        </tr>
        </tbody>
    </table>

    @if ($editingUser)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
            <div class="bg-white p-6 rounded shadow-lg">
                <h2 class="text-xl font-bold mb-4">Editar Usuario</h2>
                <label class="block">Nombre:</label>
                <input type="text" wire:model="name" class="border p-2 w-full mb-2">

                <label class="block">Email:</label>
                <input type="email" wire:model="email" class="border p-2 w-full mb-2">

                <div class="flex justify-end">
                    <button wire:click="updateUser" class="bg-green-500 text-white px-4 py-2 rounded">Guardar</button>
                    <button wire:click="$set('editingUser', false)" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">Cancelar</button>
                </div>
            </div>
        </div>
    @endif

    @if ($creatingUser)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
            <div class="bg-white p-6 rounded shadow-lg">
                <h2 class="text-xl font-bold mb-4">Crear Usuario</h2>
                <label class="block">Nombre:</label>
                <input type="text" wire:model="name" class="border p-2 w-full mb-2">

                <label class="block">Username:</label>
                <input type="text" wire:model="username" class="border p-2 w-full mb-2">

                <label class="block">Email:</label>
                <input type="email" wire:model="email" class="border p-2 w-full mb-2">

                <label class="block">Contraseña:</label>
                <input type="password" wire:model="password" class="border p-2 w-full mb-2">

                <div class="flex justify-end">
                    <button wire:click="createUser" class="bg-green-500 text-white px-4 py-2 rounded">Guardar</button>
                    <button wire:click="$set('creatingUser', false)" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">Cancelar</button>
                </div>
            </div>
        </div>
    @endif


    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
</div>
