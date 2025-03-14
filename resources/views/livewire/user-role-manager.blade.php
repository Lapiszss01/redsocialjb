<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <table class="min-w-full bg-white border border-gray-300">
        <thead>
        <tr class="bg-gray-200">
            <th class="py-2 px-4 border">Nombre</th>
            <th class="py-2 px-4 border">Email</th>
            <th class="py-2 px-4 border">Rol</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr class="border">
                <td class="py-2 px-4">{{ $user->name }}</td>
                <td class="py-2 px-4">{{ $user->email }}</td>
                <td class="py-2 px-4">
                    <select wire:model="userRole.{{ $user->id }}" wire:change="updateRole({{ $user->id }}, $event.target.value)">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @if($role->id === $user->role_id) selected @endif>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
